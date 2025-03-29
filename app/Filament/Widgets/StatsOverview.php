<?php

namespace App\Filament\Widgets;

use App\Models\Competition;
use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('dashboard.stat.users'), User::count()),
            Stat::make(__('dashboard.stat.students'), Student::count()),
            Stat::make(__('dashboard.stat.majors'), Major::count()),
            Stat::make(__('dashboard.stat.subjects'), Subject::count()),
            Stat::make(__('dashboard.stat.competitions'), Competition::count()),
        ];
    }
}
