<?php

namespace App\Filament\Resources\CompetitionResource\Pages;

use App\Enum\CompetitionCriteriaSubjectType;
use App\Filament\Resources\CompetitionCriteriaResource;
use App\Filament\Resources\CompetitionResource;
use App\Rules\MaxCompetitionCriteriaTotalWeight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageCompetitionCriterias extends ManageRelatedRecords
{
    protected static string $resource = CompetitionResource::class;

    protected static string $relationship = 'criterias';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label(__('competition.field.criteria.name'))
                ->required(),
            Forms\Components\TextInput::make('weight')
                ->label(__('competition.field.criteria.weight'))
                ->numeric()
                ->default(0)
                ->minValue(0)
                ->maxValue(function () use ($form) {
                    $totalWeight = $this->getOwnerRecord()->criterias()->sum('weight');
                    if ($form->getRecord()) {
                        $totalWeight -= $form->getRecord()->weight;
                    }
                    return 100 - $totalWeight;
                })
                ->suffix('%')
                ->rules([
                    new MaxCompetitionCriteriaTotalWeight(
                        ownerRecord: $this->getOwnerRecord(),
                        currentCriteriaId: $this->record?->id,
                    ),
                ])
                ->required(),
            TableRepeater::make('subjects')
                ->label(__('competition.field.criteria.subjects'))
                ->relationship('criteriaSubjects')
                ->schema([
                    Forms\Components\Select::make('subject_id')
                        ->label(__('competition.field.criteria.subject'))
                        ->relationship(
                            name: 'subject',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn($query) =>
                            $query->whereHas(
                                'majors',
                                fn($query) =>
                                $query->whereIn(
                                    'major_id',
                                    $this->getRecord()->majors()->pluck('id'),
                                ),
                            )
                        )
                        ->preload()
                        ->searchable()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                        ->required(),

                    Forms\Components\TextInput::make('target_score')
                        ->label(__('competition.field.criteria.subject.target-score'))
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->required()
                        ->reactive(),
                    Forms\Components\Select::make('type')
                        ->label(__('competition.field.criteria.subject.type'))
                        ->options(CompetitionCriteriaSubjectType::class)
                        ->preload()
                        ->searchable()
                        ->columnSpanFull()
                        ->required(),
                ])
                ->addable(fn($get) => array_sum(
                    collect($get('subjects'))
                        ->pluck('weight')
                        ->map(fn($weight) => (int) $weight) // Ensure all values are integers
                        ->toArray()
                ) < 100)
                ->rules([
                    function ($get) {
                        return function (string $attribute, $value, $fail) use ($get) {
                            $totalWeight = array_sum(
                                collect($get('subjects'))
                                    ->pluck('weight')
                                    ->map(fn($weight) => (int) $weight) // Ensure all values are integers
                                    ->toArray()
                            );

                            if ($totalWeight > 100) {
                                $fail(__('competition.validation.criteria.max_subject_total_weight', [
                                    'max' => 100,
                                ]));
                            }
                        };
                    }
                ])
                ->reactive()
                ->columns(2)
                ->columnSpanFull()
                ->defaultItems(1)
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('competition.nav.criteria.title'))
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('competition.column.criteria.name')),
                Tables\Columns\TextColumn::make('weight')
                    ->label(__('competition.column.criteria.weight'))
                    ->formatStateUsing(fn($state) => $state . '%')
                    ->badge()
                    ->color(fn($state): string => match ($state) {
                        $state < 50 => 'warning',
                        $state < 75 => 'danger',
                        default => 'success',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('subjects')
                    ->label(__('competition.column.criteria.subjects'))
                    ->formatStateUsing(fn($state) => $state->name . ' (' . $state->pivot->type->getLabel() . ')')
                    ->badge()
                    ->color(fn($state) => $state->pivot->type->getColor()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modelLabel(__('competition.nav.criteria.title'))
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->paginated(false);
    }

    public function getTitle(): string|Htmlable
    {
        return __('competition.nav.criteria.label') . ' ' . $this->getOwnerRecord()->name;
    }

    public static function getNavigationLabel(): string
    {
        return __('competition.nav.criteria.label');
    }

    public static function getNavigationIcon(): string
    {
        return __('competition.nav.criteria.icon');
    }

    public function canCreate(): bool
    {
        return $this->getOwnerRecord()->criterias()->sum('weight') < 100;
    }
}
