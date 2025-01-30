<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class MaxCompetitionCriteriaTotalWeight implements ValidationRule
{
    protected ?Model $ownerRecord;
    protected ?int $currentCriteriaId;
    protected int $maxTotalWeight;

    public function __construct(?Model $ownerRecord, ?int $currentCriteriaId = null, int $maxTotalWeight = 100)
    {
        $this->ownerRecord = $ownerRecord;
        $this->currentCriteriaId = $currentCriteriaId;
        $this->maxTotalWeight = $maxTotalWeight;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $totalWeight = $this->ownerRecord->criterias()
            ->when($this->currentCriteriaId, function ($query) {
                $query->where('id', '!=', $this->currentCriteriaId);
            })
            ->sum('weight');

        $totalWeight += $value;

        if ($totalWeight > $this->maxTotalWeight) {
            $fail(__('competition-criteria.validation.max_criteria_total_weight', [
                'max' => $this->maxTotalWeight,
            ]));
        }
    }
}
