<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use App\Models\Subject;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageStudentSubjectScore extends ManageRelatedRecords
{
    protected static string $resource = StudentResource::class;

    protected static string $relationship = 'subjects';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Scores';
    }

    public function mount($record): void
    {
        parent::mount($record);
        $validSubjectIds = $this->record->major->subjects()->pluck('id');
        $currentSubjectIds = $this->record->subjects()->pluck('subject_id');

        $subjectsToDetach = $currentSubjectIds->diff($validSubjectIds);
        if ($subjectsToDetach->isNotEmpty()) {
            $this->record->subjects()->detach($subjectsToDetach);
        }

        $subjectsToAttach = $validSubjectIds->diff($currentSubjectIds)
            ->mapWithKeys(fn($id) => [$id => ['score' => 0]])
            ->all();

        if (!empty($subjectsToAttach)) {
            $this->record->subjects()->syncWithoutDetaching($subjectsToAttach);
        }
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('subject.nav.label')),
                Tables\Columns\TextInputColumn::make('pivot.score')
                    ->label('Score')
                    ->type('number')
                    ->rules(['numeric', 'min:0', 'max:100'])
                    ->updateStateUsing(function ($record, $state) {
                        $record->pivot->update(['score' => $state]);
                    }),
            ])
            ->filters([
                //
            ])
            ->paginated(false);
    }
}
