<?php

namespace App\Filament\Pages;

use App\Models\Session;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Tables\Table;

class Sessions extends Page implements HasTable
{
    use HasPageShield, InteractsWithTable;

    protected static ?string $model = Session::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.sessions';

    public static function table(Table $table): Table
    {
        return $table
            ->query(Session::forCurrentUser())
            ->searchable(false)
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP Address'),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->searchable(),
                TextColumn::make('last_activity')
                    ->label('Last Activity')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
