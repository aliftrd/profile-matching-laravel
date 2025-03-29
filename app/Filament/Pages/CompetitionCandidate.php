<?php

namespace App\Filament\Pages;

use App\Enum\CompetitionCriteriaSubjectType;
use App\Enum\ScoreWeightEnum;
use App\Enum\WeightConversionEnum;
use App\Models\Competition;
use App\Traits\HasActiveIcon;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;

class CompetitionCandidate extends Page
{
    use HasPageShield;
    use HasActiveIcon;
    use InteractsWithFormActions;

    protected static string $view = 'filament.pages.competition-candidate';

    public ?int $competitionId;
    protected ?Competition $competition;
    protected ?Collection $students;
    protected array $subjectTargetedScores = [];
    protected array $studentMappingScores = [];
    protected ?Collection $topStudents;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\Select::make('competitionId')
                        ->label(__('candidate.field.competition'))
                        ->options(Competition::pluck('name', 'id'))
                        ->preload()
                        ->searchable()
                        ->required(),
                ])
            ]);
    }

    public function getFormActions(): array
    {
        return [
            Action::make('search')
                ->label(__('candidate.button.search'))
                ->action(fn() => $this->processCandidates()),
        ];
    }

    private function processCandidates()
    {
        $this->validate([
            'competitionId' => 'required',
        ]);

        $this->loadCompetitionData();
        $this->calculateScores();
        $this->topStudents = $this->students->sortByDesc(
            fn($student) => $this->studentMappingScores[$student->id]['total_score'] ?? PHP_INT_MIN
        )->values();
    }

    private function loadCompetitionData()
    {
        $this->competition = Competition::with([
            'majors.students.subjects',
            'criterias.subjects',
        ])->findOrFail($this->competitionId);

        $this->students = $this->competition->majors->pluck('students')->flatten();

        $this->subjectTargetedScores = $this->competition->criterias
            ->flatMap->subjects
            ->mapWithKeys(fn($subject) => [$subject->id => ScoreWeightEnum::fromScore($subject->pivot->target_score)])
            ->toArray();
    }

    private function calculateScores()
    {
        foreach ($this->students as $student) {
            $studentId = $student->id;
            $this->studentMappingScores[$studentId] = ['total_score' => 0];

            foreach ($this->competition->criterias as $criteria) {
                $this->calculateCriteriaScore($student, $criteria, $studentId);
            }
        }
    }

    private function calculateCriteriaScore($student, $criteria, $studentId)
    {
        $criteriaId = $criteria->id;
        $this->studentMappingScores[$studentId][$criteriaId] = [];

        $criteriaTypeScores = [];

        foreach ($criteria->subjects as $subject) {
            $this->calculateSubjectScore($student, $criteriaTypeScores, $subject, $studentId, $criteriaId);
        }

        $this->computeWeightedScore($criteria, $studentId, $criteriaId, $criteriaTypeScores);
    }

    private function calculateSubjectScore($student, &$criteriaTypeScores, $subject, $studentId, $criteriaId)
    {
        $subjectId = $subject->id;
        $subjectType = $subject->pivot->type->value;
        $score = optional($student->subjects->firstWhere('id', $subjectId))->pivot->score ?? 0;

        $normalizedScore = ScoreWeightEnum::fromScore($score)->value;
        $targetScore = $this->subjectTargetedScores[$subjectId]->value ?? 0;
        $gap = $normalizedScore - $targetScore;
        $gapScore = WeightConversionEnum::fromGap($gap);

        $this->studentMappingScores[$studentId][$criteriaId][$subjectId] = [
            'score' => $normalizedScore,
            'gap' => $gap,
            'gap_score' => $gapScore,
            'type' => $subjectType,
        ];

        if (!isset($criteriaTypeScores[$subjectType])) {
            $criteriaTypeScores[$subjectType] = ['sum' => 0, 'count' => 0];
        }

        $criteriaTypeScores[$subjectType]['sum'] += $gapScore;
        $criteriaTypeScores[$subjectType]['count']++;
    }

    private function computeWeightedScore($criteria, $studentId, $criteriaId, $criteriaTypeScores)
    {
        $this->studentMappingScores[$studentId][$criteriaId]['type_totals'] = [];
        $totalWeightedScore = 0;

        foreach ($criteriaTypeScores as $type => $data) {
            $averageScore = round($data['count'] > 0 ? $data['sum'] / $data['count'] : 0, 3);
            $this->studentMappingScores[$studentId][$criteriaId]['type_totals'][$type] = $averageScore;

            $weight = $type === CompetitionCriteriaSubjectType::CORE->value ? 60 : 40;
            $totalWeightedScore += ($weight / 100) * $averageScore;
        }

        $this->studentMappingScores[$studentId][$criteriaId]['total_weighted_score'] = round($totalWeightedScore, 3);
        $this->studentMappingScores[$studentId]['total_score'] += round(($criteria->weight / 100) * $totalWeightedScore, 3);
    }

    public static function getNavigationLabel(): string
    {
        return __('candidate.nav.label');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return __('candidate.nav.icon');
    }

    public function getTitle(): string | Htmlable
    {
        return __('candidate.nav.label');
    }

    public function getHeading(): string
    {
        return __('candidate.nav.label');
    }
}
