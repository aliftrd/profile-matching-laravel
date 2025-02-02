<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages;
use App\Filament\Resources\CompetitionResource\Pages\ManageCompetitionCriterias;
use App\Models\Competition;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('competition.field.name'))
                            ->required(),
                        Forms\Components\Select::make('majors')
                            ->label(__('competition.field.major'))
                            ->relationship('majors', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('competition.column.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('majors.name')
                    ->label(__('competition.column.major'))
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('competition.column.updated_at'))
                    ->since()
                    ->sortable(),
            ])
            ->filters([
                // 
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('criterias')
                        ->label(__('competition.nav.criteria.title'))
                        ->icon(__('competition.nav.criteria.icon'))
                        ->color('info')
                        ->url(fn($record) => ManageCompetitionCriterias::getUrl(['record' => $record])),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getLabel(): ?string
    {
        return __('competition.nav.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('competition.nav.group');
    }

    public static function getNavigationIcon(): ?string
    {
        return __('competition.nav.icon');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompetitions::route('/'),
            'create' => Pages\CreateCompetition::route('/create'),
            'edit' => Pages\EditCompetition::route('/{record}/edit'),
            'criterias' => Pages\ManageCompetitionCriterias::route('/{record}/criterias'),
        ];
    }
}
