<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourHotspotResource\Pages;
use App\Models\TourHotspot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TourHotspotResource extends Resource
{
    protected static ?string $model = TourHotspot::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = '360° Tour';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Tour Hotspots';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Location')->schema([
                Forms\Components\Select::make('tour_scene_id')
                    ->label('In scene')
                    ->relationship('scene', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('label')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Enter the Factory Floor'),
            ])->columns(2),

            Forms\Components\Section::make('Position')
                ->description('Yaw = horizontal direction (0–360°). Pitch = vertical direction (-90 to +90°). Tip: click in the panorama preview on the tour page and read the coordinates from the browser console.')
                ->schema([
                    Forms\Components\TextInput::make('yaw')
                        ->numeric()
                        ->step(1)
                        ->required()
                        ->suffix('°'),

                    Forms\Components\TextInput::make('pitch')
                        ->numeric()
                        ->step(1)
                        ->required()
                        ->suffix('°'),
                ])->columns(2),

            Forms\Components\Section::make('Action')->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'scene' => 'Go to another scene',
                        'info'  => 'Show info text',
                        'url'   => 'Open a link',
                    ])
                    ->default('scene')
                    ->required()
                    ->live()
                    ->native(false),

                Forms\Components\Select::make('target_scene_id')
                    ->label('Target scene')
                    ->relationship('targetScene', 'name')
                    ->searchable()
                    ->preload()
                    ->required(fn (Forms\Get $get) => $get('type') === 'scene')
                    ->visible(fn (Forms\Get $get) => $get('type') === 'scene'),

                Forms\Components\TextInput::make('url')
                    ->url()
                    ->visible(fn (Forms\Get $get) => $get('type') === 'url'),

                Forms\Components\Textarea::make('description')
                    ->rows(2)
                    ->columnSpanFull()
                    ->helperText('Optional — used for info hotspots or tooltips'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scene.name')
                    ->label('In scene')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('label')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'scene',
                        'info'    => 'info',
                        'warning' => 'url',
                    ]),

                Tables\Columns\TextColumn::make('targetScene.name')
                    ->label('Goes to')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('yaw')
                    ->suffix('°')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('pitch')
                    ->suffix('°')
                    ->toggleable(),
            ])
            ->defaultSort('tour_scene_id')
            ->filters([
                Tables\Filters\SelectFilter::make('tour_scene_id')
                    ->label('Scene')
                    ->relationship('scene', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'scene' => 'Go to scene',
                        'info'  => 'Info text',
                        'url'   => 'Open link',
                    ]),
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
            'index'  => Pages\ListTourHotspots::route('/'),
            'create' => Pages\CreateTourHotspot::route('/create'),
            'edit'   => Pages\EditTourHotspot::route('/{record}/edit'),
        ];
    }
}