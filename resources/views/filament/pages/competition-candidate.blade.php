<x-filament-panels::page>
    <x-filament-panels::form wire:submit="search" class="pl-[50px]">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>

    @isset($this->competition, $this->students)
        @php
            // Extract all criterias linked to the competition
            $criterias = $this->competition->criterias;
        @endphp

        <x-filament::section>
            <x-slot name="heading">
                <div class="flex justify-between items-center w-full">
                    <span>Hasil Nilai Akhir</span>
                    <x-filament::modal width="6xl">
                        <x-slot name="trigger">
                            <x-filament::button>
                                {{ __('candidate.table.detail-calculation') }}
                            </x-filament::button>
                        </x-slot>

                        <x-slot name="heading">
                            {{ __('candidate.table.detail-calculation') }}
                        </x-slot>

                        <x-filament::section collapsible="true" compact>
                            <x-slot name="heading">{{ __('candidate.table.start-score') }}</x-slot>
                            <div class="overflow-x-auto">
                                <table
                                    class="fi-ta-table border w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6"
                                                rowspan="2">
                                                {{ __('candidate.column.name') }}
                                            </th>
                                            @foreach ($criterias as $criteria)
                                                <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center"
                                                    colspan="{{ count($criteria->subjects) }}">
                                                    {{ $criteria->name }} ({{ $criteria->weight }}%)
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            @foreach ($criterias as $criteria)
                                                @foreach ($criteria->subjects as $subject)
                                                    <th
                                                        class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-xs">
                                                        <div class="flex flex-col items-center justify-center gap-2">
                                                            {{ $subject->name }}
                                                            <x-filament::badge size="sm"
                                                                color="{{ $subject->pivot->type->getColor() }}">
                                                                {{ $subject->pivot->type->getSmallLabel() }}
                                                            </x-filament::badge>
                                                        </div>
                                                    </th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                                        @foreach ($this->students as $student)
                                            <tr
                                                class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                                <td
                                                    class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                                    <div class="fi-ta-col-wrp">
                                                        {{ $student->name }}
                                                    </div>
                                                </td>
                                                @foreach ($criterias as $criteria)
                                                    @foreach ($criteria->subjects as $subject)
                                                        @php
                                                            $score = $student->subjects->firstWhere('id', $subject->id)
                                                                ?->pivot->score;
                                                        @endphp
                                                        <td
                                                            class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                            <div class="fi-ta-col-wrp">
                                                                {{ $score ?? 0 }}
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfooter class="divide-y divide-gray-200 dark:divide-white/5">
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6"
                                                rowspan="2">
                                                {{ __('candidate.table.targeted-score') }}
                                            </th>
                                            @foreach ($criterias as $criteria)
                                                @foreach ($criteria->subjects as $subject)
                                                    <th
                                                        class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                        {{ $subject->pivot->target_score }}
                                                    </th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    </tfooter>
                                </table>
                            </div>
                        </x-filament::section>

                        <x-filament::section collapsible="true" compact>
                            <x-slot name="heading">{{ __('candidate.table.weighting-score') }}</x-slot>
                            <div class="overflow-x-auto">
                                <table
                                    class="fi-ta-table border w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6"
                                                rowspan="2">
                                                {{ __('candidate.column.name') }}
                                            </th>
                                            @foreach ($criterias as $criteria)
                                                <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center"
                                                    colspan="{{ count($criteria->subjects) }}">
                                                    {{ $criteria->name }} ({{ $criteria->weight }}%)
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            @foreach ($criterias as $criteria)
                                                @foreach ($criteria->subjects as $subject)
                                                    <th
                                                        class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-xs">
                                                        <div class="flex flex-col items-center justify-center gap-2">
                                                            {{ $subject->name }}
                                                            <x-filament::badge size="sm"
                                                                color="{{ $subject->pivot->type->getColor() }}">
                                                                {{ $subject->pivot->type->getSmallLabel() }}
                                                            </x-filament::badge>
                                                        </div>
                                                    </th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                                        @foreach ($this->students as $student)
                                            <tr
                                                class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                                <td
                                                    class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                                    <div class="fi-ta-col-wrp">
                                                        {{ $student->name }}
                                                    </div>
                                                </td>
                                                @foreach ($criterias as $criteria)
                                                    @foreach ($criteria->subjects as $subject)
                                                        <td
                                                            class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                            <div class="fi-ta-col-wrp">
                                                                {{ $this->studentMappingScores[$student->id][$criteria->id][$subject->id]['score'] ?? 0 }}
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            <th
                                                class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                                {{ __('candidate.table.targeted-score') }}
                                            </th>
                                            @foreach ($criterias as $criteria)
                                                @foreach ($criteria->subjects as $subject)
                                                    <td
                                                        class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                        <div class="fi-ta-col-wrp">
                                                            {{ $this->subjectTargetedScores[$subject->id] }}
                                                        </div>
                                                    </td>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                        @foreach ($this->students as $student)
                                            <tr
                                                class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                                <td
                                                    class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                                    <div class="fi-ta-col-wrp">
                                                        {{ $student->name }}
                                                    </div>
                                                </td>
                                                @foreach ($criterias as $criteria)
                                                    @foreach ($criteria->subjects as $subject)
                                                        <td
                                                            class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                            <div class="fi-ta-col-wrp">
                                                                {{ $this->studentMappingScores[$student->id][$criteria->id][$subject->id]['gap'] ?? 0 }}
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-filament::section>

                        <x-filament::section collapsible="true" compact>
                            <x-slot name="heading">{{ __('candidate.table.convertion-score') }}</x-slot>
                            <div class="overflow-x-auto">
                                <table
                                    class="fi-ta-table border w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6"
                                                rowspan="2">
                                                {{ __('candidate.column.name') }}
                                            </th>
                                            @foreach ($criterias as $criteria)
                                                <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center"
                                                    colspan="{{ count($criteria->subjects) }}">
                                                    {{ $criteria->name }} ({{ $criteria->weight }}%)
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            @foreach ($criterias as $criteria)
                                                @foreach ($criteria->subjects as $subject)
                                                    <th
                                                        class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-xs">
                                                        <div class="flex flex-col items-center justify-center gap-2">
                                                            {{ $subject->name }}
                                                            <x-filament::badge size="sm"
                                                                color="{{ $subject->pivot->type->getColor() }}">
                                                                {{ $subject->pivot->type->getSmallLabel() }}
                                                            </x-filament::badge>
                                                        </div>
                                                    </th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                                        @foreach ($this->students as $student)
                                            <tr
                                                class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                                <td
                                                    class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                                    <div class="fi-ta-col-wrp">
                                                        {{ $student->name }}
                                                    </div>
                                                </td>
                                                @foreach ($criterias as $criteria)
                                                    @foreach ($criteria->subjects as $subject)
                                                        <td
                                                            class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                            <div class="fi-ta-col-wrp">
                                                                {{ $this->studentMappingScores[$student->id][$criteria->id][$subject->id]['gap_score'] ?? 0 }}
                                                            </div>
                                                        </td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-filament::section>

                        <x-filament::section collapsible="true" compact>
                            <x-slot name="heading">{{ __('candidate.table.grouping-score') }}</x-slot>
                            <div class="overflow-x-auto">
                                <table
                                    class="fi-ta-table border w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6"
                                                rowspan="2">
                                                {{ __('candidate.column.name') }}
                                            </th>
                                            @foreach ($criterias as $criteria)
                                                <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center"
                                                    colspan="3">
                                                    {{ $criteria->name }} ({{ $criteria->weight }}%)
                                                </th>
                                            @endforeach
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-white/5">
                                            @foreach ($criterias as $criteria)
                                                @foreach (App\Enum\CompetitionCriteriaSubjectType::cases() as $type)
                                                    <th
                                                        class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-xs">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <x-filament::badge size="sm"
                                                                color="{{ $type->getColor() }}">
                                                                {{ $type->getSmallLabel() }}
                                                            </x-filament::badge>
                                                        </div>
                                                    </th>
                                                @endforeach
                                                <th
                                                    class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-xs">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <x-filament::badge size="sm">
                                                            NA
                                                        </x-filament::badge>
                                                    </div>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                                        @foreach ($this->students as $student)
                                            <tr
                                                class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                                <td
                                                    class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                                    <div class="fi-ta-col-wrp">
                                                        {{ $student->name }}
                                                    </div>
                                                </td>
                                                @foreach ($criterias as $criteria)
                                                    <td
                                                        class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                        <div class="fi-ta-col-wrp">
                                                            {{ $this->studentMappingScores[$student->id][$criteria->id]['type_totals']['core'] }}
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                        <div class="fi-ta-col-wrp">
                                                            {{ $this->studentMappingScores[$student->id][$criteria->id]['type_totals']['secondary'] }}
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                                        <div class="fi-ta-col-wrp">
                                                            {{ $this->studentMappingScores[$student->id][$criteria->id]['total_weighted_score'] }}
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </x-filament::section>
                    </x-filament::modal>
                </div>
            </x-slot>

            <div class="overflow-x-auto">
                <table
                    class="fi-ta-table border w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                    <thead class="divide-y divide-gray-200 dark:divide-white/5">
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <th
                                class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-start">
                                {{ __('candidate.column.name') }}
                            </th>
                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                {{ __('candidate.table.end-score') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                        @foreach ($this->topStudents as $student)
                            <tr
                                class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                    <div class="fi-ta-col-wrp">
                                        {{ $student->name }}
                                    </div>
                                </td>
                                <td class="fi-ta-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center">
                                    <div class="fi-ta-col-wrp">
                                        {{ $this->studentMappingScores[$student->id]['total_score'] }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    @endisset
</x-filament-panels::page>
