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
    protected static ?string $navigationGroup = 'Virtual Tour';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Scene')->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'title')
                    ->searchable()->preload(),

                Forms\Components\TextInput::make('name')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Str::slug($state))),

                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')->rows(2)->columnSpanFull(),
                Forms\Components\Toggle::make('is_start')->label('Starting scene'),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
            ])->columns(2),

            Forms\Components\Section::make('Initial camera')->schema([
                Forms\Components\TextInput::make('initial_yaw')->numeric()->step(1)->default(0)
                    ->helperText('Degrees, 0 = north'),
                Forms\Components\TextInput::make('initial_pitch')->numeric()->step(1)->default(0)
                    ->helperText('Degrees, 0 = level, +up, -down'),
                Forms\Components\TextInput::make('initial_hfov')->numeric()->step(1)->default(100)
                    ->helperText('Horizontal field of view'),
            ])->columns(3),

            Forms\Components\Section::make('Panorama')->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('panorama')
                    ->collection('panorama')->image()
                    ->helperText('Equirectangular JPG, min 4096×2048'),
            ]),

            Forms\Components\Section::make('Hotspots (links to other scenes)')->schema([
                Forms\Components\Repeater::make('hotspots')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('target_scene_id')
                            ->label('Target scene')
                            ->relationship('targetScene', 'name')
                            ->searchable()->preload()->required(),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('yaw')->numeric()->step(1)->required(),
                            Forms\Components\TextInput::make('pitch')->numeric()->step(1)->required(),
                        ]),

                        Forms\Components\TextInput::make('label')
                            ->placeholder('Go to Factory Floor'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                    ->defaultItems(0)
                    ->reorderable()
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('order')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('project.title')->label('Project')->toggleable(),
            Tables\Columns\IconColumn::make('is_start')->boolean()->label('Start'),
            Tables\Columns\TextColumn::make('hotspots_count')->counts('hotspots')->label('Links'),
        ])
        ->defaultSort('order')
        ->reorderable('order')
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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