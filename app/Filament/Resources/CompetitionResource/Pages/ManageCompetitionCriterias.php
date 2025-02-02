<?php

namespace App\Filament\Resources\CompetitionResource\Pages;

use App\Enum\CompetitionCriteriaType;
use App\Filament\Resources\CompetitionResource;
use App\Rules\MaxCompetitionCriteriaTotalWeight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
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
                    if (!$form->getRecord()) {
                        return 100 - $this->getOwnerRecord()->criterias()->sum('weight');
                    }

                    return 100 - $this->getOwnerRecord()->criterias()
                        ->whereKeyNot($form->getRecord()->getKey())
                        ->sum('weight');
                })
                ->suffix('%')
                ->rules([
                    new MaxCompetitionCriteriaTotalWeight(
                        ownerRecord: $this->getOwnerRecord(),
                        currentCriteriaId: $form->getRecord()?->id,
                    ),
                ])
                ->required(),
            Forms\Components\Select::make('subject')
                ->label(__('competition.field.criteria.subject'))
                ->relationship('subjects', 'name')
                ->multiple()
                ->preload()
                ->searchable()
                ->required(),
            Forms\Components\Select::make('type')
                ->label(__('competition.field.criteria.type'))
                ->options(CompetitionCriteriaType::class)
                ->preload()
                ->searchable()
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('type')
                    ->label(__('competition.column.criteria.type'))
                    ->badge(),
                Tables\Columns\TextColumn::make('subjects.name')
                    ->label(__('competition.column.criteria.subject'))
                    ->badge(),

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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
