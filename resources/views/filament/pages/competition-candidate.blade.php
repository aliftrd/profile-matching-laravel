<x-filament-panels::page>
    <x-filament-panels::form wire:submit="greet" class="pl-[50px]">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()" :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>

    @isset($this->competition, $this->students)
        @php
            // Extract all criterias linked to the competition
            $criterias = $this->competition->criterias;
        @endphp
        <section class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-content-ctn">
                <div class="fi-section-content p-6">
                    <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                        <thead class="divide-y divide-gray-200 dark:divide-white/5">
                            <tr class="bg-gray-50 dark:bg-white/5">
                                <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6"
                                    rowspan="2">
                                    {{ __('student.column.name') }}
                                </th>
                                @foreach ($criterias as $criteria)
                                    <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-center"
                                        colspan="{{ count($criteria->subjects) }}">
                                        <div class="flex items-center justify-center gap-2">
                                            {{ $criteria->name }} ({{ $criteria->weight }}%)
                                            <x-filament::badge size="sm">
                                                {{ $criteria->type->getLabel() }}
                                            </x-filament::badge>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="bg-gray-50 dark:bg-white/5">
                                @foreach ($criterias as $criteria)
                                    @foreach ($criteria->subjects as $subject)
                                        <th
                                            class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 text-xs">
                                            {{ $subject->name }} ({{ $subject->pivot->weight }}%)</th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                            @foreach ($this->students as $student)
                                <tr
                                    class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td
                                        class="fi-ta-cell p-2 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                        <div class="fi-ta-col-wrp">
                                            {{ $student->name }}
                                        </div>
                                    </td>
                                    @foreach ($criterias as $criteria)
                                        @foreach ($criteria->subjects as $subject)
                                            @php
                                                $score = $student->subjects->firstWhere('id', $subject->id)?->pivot
                                                    ->score;
                                            @endphp
                                            <td
                                                class="fi-ta-cell p-2 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 text-center">
                                                <div class="fi-ta-col-wrp">
                                                    {{ $score ?? 0 }}
                                                </div>
                                            </td>
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endisset
</x-filament-panels::page>
