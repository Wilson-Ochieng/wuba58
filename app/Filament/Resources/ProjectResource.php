<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Project')->tabs([

                Forms\Components\Tabs\Tab::make('Details')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                            $set('slug', \Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\Select::make('category')
                        ->options([
                            'residential' => 'Residential',
                            'commercial'  => 'Commercial',
                            'masterplan'  => 'Masterplan',
                            'mixed_use'   => 'Mixed Use',
                        ])
                        ->required()
                        ->native(false),

                    Forms\Components\TextInput::make('location')->maxLength(255),
                    Forms\Components\TextInput::make('scale')->maxLength(255)->placeholder('1:500'),
                    Forms\Components\TextInput::make('client_name')->maxLength(255),
                    Forms\Components\TextInput::make('year')->numeric()->minValue(1900)->maxValue(2100),

                    Forms\Components\Textarea::make('excerpt')->rows(3)->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')->columnSpanFull(),

                    Forms\Components\Toggle::make('featured'),
                    Forms\Components\Toggle::make('published')->default(true),
                    Forms\Components\DateTimePicker::make('published_at')->default(now()),
                    Forms\Components\TextInput::make('order')->numeric()->default(0),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Media')->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('hero')
                        ->collection('hero')->image()->imageEditor(),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                        ->collection('gallery')->image()->multiple()->reorderable(),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('process')
                        ->collection('process')->image()->multiple()->reorderable(),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('before')
                        ->collection('before')->image()->imageEditor(),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('after')
                        ->collection('after')->image()->imageEditor(),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('video')
                        ->collection('video')->acceptedFileTypes(['video/mp4', 'video/webm']),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('model')
                        ->collection('model')
                        ->acceptedFileTypes(['model/gltf-binary', 'application/octet-stream'])
                        ->helperText('Upload .glb file (Draco-compressed recommended)'),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('panorama')
                        ->collection('panorama')->image()->multiple(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('3D Hotspots')->schema([
                    Forms\Components\Repeater::make('hotspots')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('label')
                                ->required()
                                ->placeholder('BUILDING A'),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('position_x')->numeric()->step(0.01)->default(0),
                                Forms\Components\TextInput::make('position_y')->numeric()->step(0.01)->default(0),
                                Forms\Components\TextInput::make('position_z')->numeric()->step(0.01)->default(0),
                            ]),

                            Forms\Components\Textarea::make('description')->rows(2)->columnSpanFull(),

                            Forms\Components\ColorPicker::make('color')->default('#d4af37'),
                            Forms\Components\TextInput::make('order')->numeric()->default(0),
                        ])
                        ->columns(2)
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                        ->defaultItems(0)
                        ->reorderable()
                        ->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('hero')
                    ->collection('hero')->conversion('thumb')->height(50),

                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('location')->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'primary' => 'residential',
                        'success' => 'commercial',
                        'warning' => 'masterplan',
                        'danger'  => 'mixed_use',
                    ]),
                Tables\Columns\IconColumn::make('featured')->boolean(),
                Tables\Columns\IconColumn::make('published')->boolean(),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->since()->toggleable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')->options([
                    'residential' => 'Residential',
                    'commercial'  => 'Commercial',
                    'masterplan'  => 'Masterplan',
                    'mixed_use'   => 'Mixed Use',
                ]),
                Tables\Filters\TernaryFilter::make('featured'),
                Tables\Filters\TernaryFilter::make('published'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}