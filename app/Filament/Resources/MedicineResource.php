<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicineResource\Pages;
use App\Models\Medicine;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;


    protected static ?string $slug = 'medicines';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-beaker';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(150)
                    ->placeholder('e.g., Paracetamol'),

                TextInput::make('description')
                    ->maxLength(500)
                    ->placeholder('Short description...'),

                TextInput::make('brand_names')
                    ->placeholder('Comma-separated brand names')
                    ->maxLength(255),

                TextInput::make('active_ingredient')
                    ->maxLength(150),

                TextInput::make('strength')
                    ->maxLength(50),

                TextInput::make('strength_unit')
                    ->maxLength(50),

                TextInput::make('manufacturer')
                    ->maxLength(150),

                Select::make('pharmacy_id')
                    ->relationship('pharmacy', 'name')
                    ->searchable(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn(?Medicine $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn(?Medicine $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->description),

                TextColumn::make('brand_names')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->brand_names),

                TextColumn::make('active_ingredient')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->active_ingredient),

                TextColumn::make('strength')
                    ->icon('heroicon-o-beaker'),

                TextColumn::make('strength_unit')
                    ->badge()
                    ->color('info'),

                TextColumn::make('manufacturer')
                    ->icon('heroicon-o-building-office'),

                TextColumn::make('pharmacy.name')
                    ->label('Pharmacy')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('pharmacy_id')
                    ->label('Pharmacy')
                    ->relationship('pharmacy','name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['pharmacy']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'pharmacy.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->pharmacy) {
            $details['Pharmacy'] = $record->pharmacy->name;
        }

        return $details;
    }
}
