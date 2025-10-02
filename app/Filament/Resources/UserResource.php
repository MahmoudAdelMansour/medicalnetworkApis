<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\PrescriptionsRelationManager;
use App\Models\User;
use App\Enums\UserType;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(150),

                TextInput::make('email')
                    ->email()
                    ->prefixIcon('heroicon-o-envelope')
                    ->required(),

                TextInput::make('phone')
                    ->tel()
                    ->prefixIcon('heroicon-o-phone')
                    ->maxLength(20),

                TextInput::make('address')
                    ->maxLength(255),

                Select::make('type')
                    ->label('User Type')
                    ->required()
                    ->options(UserType::options()),

                DatePicker::make('email_verified_at')
                    ->label('Email Verified Date'),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $operation): bool => $operation === 'create'),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn(?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn(?User $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->icon('heroicon-o-phone')
                    ->copyable()
                    ->copyMessage('Phone copied'),

                TextColumn::make('address')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->address),

                TextColumn::make('type')
                    ->label('User Type')
                    ->badge()
                    ->color(fn($record) => match(($record->type instanceof \BackedEnum) ? $record->type->value : (string) $record->type) {
                        'ADMIN' => 'danger',
                        'DOCTOR' => 'info',
                        'NURSE' => 'warning',
                        'PATIENT' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => method_exists($state, 'label') ? $state->label() : (is_string($state) ? (App\Enums\UserType::tryFrom($state)?->label() ?? $state) : $state)),

                IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->color(fn($state) => $state ? 'success' : 'warning')
                    ->state(fn($record) => filled($record->email_verified_at)),

                TextColumn::make('email_verified_at')
                    ->label('Verified At')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PrescriptionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
