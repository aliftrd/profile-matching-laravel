<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Models\Subject;
use App\Traits\HasActiveIcon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class SubjectResource extends Resource
{
    use HasActiveIcon;
    protected static ?string $model = Subject::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('subject.field.name'))
                    ->required(),
                Forms\Components\Select::make('majors')
                    ->label(__('subject.field.major'))
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
                    ->label(__('subject.column.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('majors.name')
                    ->label(__('subject.column.major'))
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getLabel(): ?string
    {
        return __('subject.nav.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('subject.nav.group');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return __('subject.nav.icon');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
        ];
    }
}
