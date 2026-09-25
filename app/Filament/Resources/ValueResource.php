<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValueResource\Pages;
use App\Models\Value;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ValueResource extends Resource
{
    protected static ?string $model = Value::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Values';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->placeholder('e.g. Precision')
                ->columnSpanFull(),

            Forms\Components\Textarea::make('description')
                ->rows(4)
                ->maxLength(500)
                ->columnSpanFull(),

            Forms\Components\TextInput::make('icon')
                ->maxLength(255)
                ->placeholder('heroicon-o-sparkles')
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

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->limit(60)
                    ->toggleable(),

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
            'index'  => Pages\ListValues::route('/'),
            'create' => Pages\CreateValue::route('/create'),
            'edit'   => Pages\EditValue::route('/{record}/edit'),
        ];
    }
}