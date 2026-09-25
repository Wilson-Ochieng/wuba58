<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientCategoryResource\Pages;
use App\Models\ClientCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientCategoryResource extends Resource
{
    protected static ?string $model = ClientCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Client Categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder('e.g. Architects'),

            Forms\Components\TextInput::make('icon')
                ->maxLength(255)
                ->placeholder('heroicon-o-briefcase')
                ->helperText('Optional Heroicon name'),

            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0)
                ->helperText('Lower numbers appear first'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('icon')
                    ->toggleable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListClientCategories::route('/'),
            'create' => Pages\CreateClientCategory::route('/create'),
            'edit'   => Pages\EditClientCategory::route('/{record}/edit'),
        ];
    }
}