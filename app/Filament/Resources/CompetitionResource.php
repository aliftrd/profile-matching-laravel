<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages;
use App\Filament\Resources\CompetitionResource\RelationManagers;
use App\Models\Competition;
use Filament\Forms;
use Filament\Forms\Form;
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('competition.column.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('majors.name')
                    ->label(__('competition.column.major'))
                    ->badge(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('user.column.updated_at'))
                    ->since()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('criteria')
                        ->label(__('competition.nav.criteria.title'))
                        ->icon(__('competition.nav.criteria.icon'))
                        ->color('gray')
                        ->url(fn($record) => Pages\ManageCompetitionCriterias::getUrl(['record' => $record])),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getLabel(): ?string
    {
        return __('competition.nav.label');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return __('competition.nav.icon');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompetitions::route('/'),
            'criteria' => Pages\ManageCompetitionCriterias::route('{record}/criteria'),
        ];
    }
}
