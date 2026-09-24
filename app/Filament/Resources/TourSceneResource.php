<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourSceneResource\Pages;
use App\Models\TourScene;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TourSceneResource extends Resource
{
    protected static ?string $model = TourScene::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = '360° Tour';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Tour Scenes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Scene Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', \Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_start')
                    ->label('Starting scene')
                    ->helperText('The scene visitors see first when opening the tour')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ])->columns(2),

            Forms\Components\Section::make('Initial Camera Position')
                ->description('Where the camera looks when the scene loads. Yaw = horizontal (0-360°), Pitch = vertical (-90 to +90°), HFOV = zoom level.')
                ->schema([
                    Forms\Components\TextInput::make('initial_yaw')
                        ->numeric()
                        ->step(1)
                        ->default(0)
                        ->suffix('°'),

                    Forms\Components\TextInput::make('initial_pitch')
                        ->numeric()
                        ->step(1)
                        ->default(0)
                        ->suffix('°'),

                    Forms\Components\TextInput::make('initial_hfov')
                        ->numeric()
                        ->step(1)
                        ->default(110)
                        ->minValue(30)
                        ->maxValue(140)
                        ->suffix('°'),
                ])->columns(3),

            Forms\Components\Section::make('Panorama Image')
                ->description('Upload a 360° equirectangular JPG. Minimum 4096×2048, ideally 8192×4096 for sharp detail.')
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('panorama')
                        ->collection('panorama')
                        ->image()
                        ->imageEditor()
                        ->helperText('Equirectangular projection — NOT a normal photo')
                        ->maxSize(51200)   // 50MB
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\IconColumn::make('is_start')
                    ->label('Start')
                    ->boolean()
                    ->trueIcon('heroicon-o-play-circle')
                    ->falseIcon('heroicon-o-minus-small')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('hotspots_count')
                    ->counts('hotspots')
                    ->label('Hotspots')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_start')->label('Starting scene'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view_tour')
                    ->label('View tour')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url('/work/360-tour')
                    ->openUrlInNewTab()
                    ->color('gray'),
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
            'index'  => Pages\ListTourScenes::route('/'),
            'create' => Pages\CreateTourScene::route('/create'),
            'edit'   => Pages\EditTourScene::route('/{record}/edit'),
        ];
    }
}