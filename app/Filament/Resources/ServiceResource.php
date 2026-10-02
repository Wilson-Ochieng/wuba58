<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Services';
    protected static ?string $modelLabel = 'Service';
    protected static ?string $pluralModelLabel = 'Services';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Service Details')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', \Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Forms\Components\Select::make('group')
                    ->options(Service::GROUPS)
                    ->default('model')
                    ->required()
                    ->native(false)
                    ->helperText('Which top-level category does this service belong to?')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Content')->schema([
                Forms\Components\Textarea::make('description')
                    ->rows(4)
                    ->maxLength(500)
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('icon')
                    ->maxLength(255)
                    ->placeholder('heroicon-o-cube')
                    ->helperText('Optional Heroicon name'),

                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->image()
                    ->imageEditor()
                    ->helperText('Optional image shown on the service card'),
            ])->columns(2),

            Forms\Components\Section::make('Display')->schema([
                Forms\Components\Toggle::make('published')->default(true),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
            ])->columns(2),
        ]);
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

                Tables\Columns\TextColumn::make('group')
                    ->formatStateUsing(fn($state) => Service::GROUPS[$state] ?? $state)
                    ->badge()
                    ->color(fn($state) => $state === 'visualizations' ? 'info' : 'primary'),

                Tables\Columns\IconColumn::make('published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options(Service::GROUPS),
                Tables\Filters\TernaryFilter::make('published'),
            ])
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}