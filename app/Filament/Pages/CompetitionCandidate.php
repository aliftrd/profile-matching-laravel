<?php

namespace App\Filament\Pages;

use App\Models\Competition;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class CompetitionCandidate extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.competition-candidate';

    public ?int $competitionId;
    protected ?Competition $competition;
    protected ?Collection $students;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\Select::make('competitionId')
                        ->label('Competition')
                        ->options(Competition::pluck('name', 'id'))
                        ->preload()
                        ->searchable()
                        ->required(),
                ])
            ]);
    }

    public function getFormActions(): array
    {
        return [
            Action::make('greet')
                ->label('Get Candidate')
                ->action(function () {
                    $this->competition = Competition::with([
                        'majors',
                        'majors.students',
                        'criterias',
                        'criterias.subjects',
                    ])
                        ->find($this->competitionId);

                    $this->students = $this->competition->majors->flatMap(fn($major) => $major->students->load('subjects'));

                    Notification::make()
                        ->title(__('Hello ' . $this->competition->name))
                        ->success()
                        ->send();
                }),
        ];
    }
}
