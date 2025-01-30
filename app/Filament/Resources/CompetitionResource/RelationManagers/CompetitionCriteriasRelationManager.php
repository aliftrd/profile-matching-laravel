<?php

namespace App\Filament\Resources\CompetitionResource\RelationManagers;

use App\Enum\CompetitionCriteriaType;
use App\Rules\MaxCompetitionCriteriaTotalWeight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompetitionCriteriasRelationManager extends RelationManager
{
    protected static string $relationship = 'criterias';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('competition-criteria.field.name'))
                    ->required(),
                Forms\Components\TextInput::make('weight')
                    ->label(__('competition-criteria.field.weight'))
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
                Forms\Components\Select::make('type')
                    ->label(__('competition-criteria.field.type'))
                    ->options(CompetitionCriteriaType::class)
                    ->preload()
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('competition-criteria.nav.label'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('competition-criteria.column.name')),
                Tables\Columns\TextColumn::make('weight')
                    ->label(__('competition-criteria.column.weight'))
                    ->formatStateUsing(fn($state) => $state . '%')
                    ->badge()
                    ->color(fn($state): string => match ($state) {
                        $state < 50 => 'warning',
                        $state < 75 => 'danger',
                        default => 'success',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('competition-criteria.column.type'))
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
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
            ]);
    }

    public function canCreate(): bool
    {
        return $this->getOwnerRecord()->criterias()->sum('weight') < 100;
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('competition-criteria.nav.label');
    }
}
