<?php

namespace App\Filament\Pages;

use App\Models\Competition;
use App\Traits\CalculateProfileMatchingTrait;
use App\Traits\HasActiveIcon;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class CompetitionCandidate extends Page
{
    use HasPageShield;
    use HasActiveIcon;
    use InteractsWithFormActions;
    use CalculateProfileMatchingTrait;

    protected static string $view = 'filament.pages.competition-candidate';

    public ?int $competitionId;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\Select::make('competitionId')
                        ->label(__('candidate.field.competition'))
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
            Action::make('search')
                ->label(__('candidate.button.search'))
                ->action(function () {
                    $this->validate([
                        'competitionId' => 'required',
                    ]);

                    $this->processCandidates($this->competitionId);
                }),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('candidate.nav.label');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return __('candidate.nav.icon');
    }

    public function getTitle(): string | Htmlable
    {
        return __('candidate.nav.label');
    }

    public function getHeading(): string
    {
        return __('candidate.nav.label');
    }
}
