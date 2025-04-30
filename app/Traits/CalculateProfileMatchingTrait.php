<?php

namespace App\Traits;

use App\Enum\CompetitionCriteriaSubjectType;
use App\Enum\ScoreWeightEnum;
use App\Enum\WeightConversionEnum;
use App\Models\Competition;
use Illuminate\Support\Collection;

trait CalculateProfileMatchingTrait
{
    protected ?Competition $competition = null;
    protected ?Collection $students = null;
    protected array $subjectTargetedScores = [];
    protected array $studentMappingScores = [];
    protected ?Collection $topStudents = null;

    /**
     * Process candidates for a competition
     *
     * @param int|string $competitionId
     * @return array
     */
    private function processCandidates($competitionId): array
    {
        $this->loadCompetitionData($competitionId);
        $this->calculateScores();
        $this->topStudents = $this->students
            ->sortByDesc(fn($student) => $this->studentMappingScores[$student->id]['total_score'] ?? PHP_INT_MIN)
            ->values();

        return [
            'students' => $this->students,
            'studentMappingScores' => $this->studentMappingScores,
            'subjectTargetedScores' => $this->subjectTargetedScores,
            'topStudents' => $this->topStudents,
        ];
    }

    /**
     * Load competition data including related models
     *
     * @param int|string $competitionId
     * @return void
     */
    private function loadCompetitionData($competitionId): void
    {
        // Eager load all necessary relationships in a single query
        $this->competition = Competition::with([
            'majors.students.subjects',
            'criterias.subjects',
        ])->findOrFail($competitionId);

        // Extract and sort students
        $this->students = $this->competition->majors->pluck('students')->flatten()->sortBy('nisn');

        // Pre-compute subject target scores for faster lookups
        $this->subjectTargetedScores = $this->competition->criterias
            ->flatMap->subjects
            ->mapWithKeys(fn($subject) => [$subject->id => ScoreWeightEnum::fromScore($subject->pivot->target_score)])
            ->toArray();
    }

    /**
     * Calculate scores for all students
     *
     * @return void
     */
    private function calculateScores(): void
    {
        // Initialize scores array with capacity
        $this->studentMappingScores = [];

        foreach ($this->students as $student) {
            $studentId = $student->id;
            $this->studentMappingScores[$studentId] = ['total_score' => 0];

            // Process all criteria for each student
            foreach ($this->competition->criterias as $criteria) {
                $this->calculateCriteriaScore($student, $criteria, $studentId);
            }
        }
    }

    /**
     * Calculate score for a specific criteria
     *
     * @param mixed $student
     * @param mixed $criteria
     * @param int|string $studentId
     * @return void
     */
    private function calculateCriteriaScore($student, $criteria, $studentId): void
    {
        $criteriaId = $criteria->id;
        $this->studentMappingScores[$studentId][$criteriaId] = [];

        // Use array to collect type scores
        $criteriaTypeScores = [];

        // Process all subjects for this criteria
        foreach ($criteria->subjects as $subject) {
            $this->calculateSubjectScore($student, $criteriaTypeScores, $subject, $studentId, $criteriaId);
        }

        // Compute final weighted score
        $this->computeWeightedScore($criteria, $studentId, $criteriaId, $criteriaTypeScores);
    }

    /**
     * Calculate score for a specific subject
     *
     * @param mixed $student
     * @param array $criteriaTypeScores
     * @param mixed $subject
     * @param int|string $studentId
     * @param int|string $criteriaId
     * @return void
     */
    private function calculateSubjectScore($student, array &$criteriaTypeScores, $subject, $studentId, $criteriaId): void
    {
        $subjectId = $subject->id;
        $subjectType = $subject->pivot->type->value;

        // Find student's score for this subject
        $score = optional($student->subjects->firstWhere('id', $subjectId))->pivot->score ?? 0;

        // Calculate normalized score and gap
        $normalizedScore = ScoreWeightEnum::fromScore($score)->value;
        $targetScore = $this->subjectTargetedScores[$subjectId]->value ?? 0;
        $gap = $normalizedScore - $targetScore;
        $gapScore = WeightConversionEnum::fromGap($gap);

        // Store detailed score information
        $this->studentMappingScores[$studentId][$criteriaId][$subjectId] = [
            'score' => $normalizedScore,
            'gap' => $gap,
            'gap_score' => $gapScore,
            'type' => $subjectType,
        ];

        // Initialize type scores if needed
        if (!isset($criteriaTypeScores[$subjectType])) {
            $criteriaTypeScores[$subjectType] = ['sum' => 0, 'count' => 0];
        }

        // Accumulate scores by type
        $criteriaTypeScores[$subjectType]['sum'] += $gapScore;
        $criteriaTypeScores[$subjectType]['count']++;
    }

    /**
     * Compute weighted score based on criteria types
     *
     * @param mixed $criteria
     * @param int|string $studentId
     * @param int|string $criteriaId
     * @param array $criteriaTypeScores
     * @return void
     */
    private function computeWeightedScore($criteria, $studentId, $criteriaId, array $criteriaTypeScores): void
    {
        $this->studentMappingScores[$studentId][$criteriaId]['type_totals'] = [];
        $totalWeightedScore = 0;

        // Calculate weighted scores for each type
        foreach ($criteriaTypeScores as $type => $data) {
            // Calculate average score with proper handling of division by zero
            $averageScore = $data['count'] > 0 ? round($data['sum'] / $data['count'], 3) : 0;
            $this->studentMappingScores[$studentId][$criteriaId]['type_totals'][$type] = $averageScore;

            // Apply type-specific weighting
            $weight = $type === CompetitionCriteriaSubjectType::CORE->value ? 60 : 40;
            $totalWeightedScore += ($weight / 100) * $averageScore;
        }

        // Store final weighted scores
        $this->studentMappingScores[$studentId][$criteriaId]['total_weighted_score'] = round($totalWeightedScore, 3);
        $this->studentMappingScores[$studentId]['total_score'] += round(($criteria->weight / 100) * $totalWeightedScore, 3);
    }
}
