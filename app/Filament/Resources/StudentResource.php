<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nisn')
                    ->label(__('student.field.nisn'))
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label(__('student.field.name'))
                    ->required(),
                Forms\Components\Select::make('major_id')
                    ->label(__('student.field.major'))
                    ->relationship('major', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('classroom_id')
                    ->label(__('student.field.classroom'))
                    ->relationship('classroom', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nisn')
                    ->label(__('student.column.nisn'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('student.column.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('classroom.name')
                    ->label(__('student.column.classroom'))
                    ->badge(),
                Tables\Columns\TextColumn::make('major.name')
                    ->label(__('student.column.major'))
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
                Tables\Actions\Action::make('score')
                    ->label(__('student.nav.score.label'))
                    ->icon(__('student.nav.score.icon'))
                    ->color('info')
                    ->url(fn($record) => Pages\ManageStudentSubjectScore::getUrl(['record' => $record])),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
        return __('student.nav.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('student.nav.group');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return __('student.nav.icon');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'score' => Pages\ManageStudentSubjectScore::route('{record}/score'),
        ];
    }
}
