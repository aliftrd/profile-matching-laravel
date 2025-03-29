<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MajorResource\Pages;
use App\Filament\Resources\MajorResource\RelationManagers;
use App\Models\Major;
use App\Traits\HasActiveIcon;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MajorResource extends Resource
{
    use HasActiveIcon;
    protected static ?string $model = Major::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('major.field.name'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('major.column.name'))
                    ->searchable()
                    ->sortable(),
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
                Tables\Actions\DeleteAction::make()
                    ->using(function ($data, $record) {
                        if (
                            $record->subjects()->count() > 0 ||
                            $record->competitions()->count() > 0 ||
                            $record->students()->count() > 0
                        ) {
                            Notification::make()
                                ->danger()
                                ->title(__('notifications.data_is_in_use'))
                                ->send();

                            return;
                        }

                        return $record->delete();
                    }),
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
        return __('major.nav.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('major.nav.group');
    }

    public static function getNavigationIcon(): string|Htmlable|null
    {
        return __('major.nav.icon');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMajors::route('/'),
        ];
    }
}
