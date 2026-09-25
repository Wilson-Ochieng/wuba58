<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModelHotspotResource\Pages;
use App\Models\ModelHotspot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ModelHotspotResource extends Resource
{
    protected static ?string $model = ModelHotspot::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = '3D Model Hotspots';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Assignment')->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('label')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. BUILDING A'),

                Forms\Components\TextInput::make('color')
                    ->default('#ECB143')
                    ->maxLength(9)
                    ->helperText('Hex color for the hotspot (default: #ECB143)'),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ])->columns(2),

            Forms\Components\Section::make('3D Position')
                ->description('Coordinates on the model where the hotspot sits. X/Y/Z are the anchor point; normal X/Y/Z is the direction the hotspot faces.')
                ->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('position_x')->numeric()->step(0.001)->default(0),
                        Forms\Components\TextInput::make('position_y')->numeric()->step(0.001)->default(0),
                        Forms\Components\TextInput::make('position_z')->numeric()->step(0.001)->default(0),
                    ]),

                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('normal_x')->numeric()->step(0.001)->default(0),
                        Forms\Components\TextInput::make('normal_y')->numeric()->step(0.001)->default(0),
                        Forms\Components\TextInput::make('normal_z')->numeric()->step(0.001)->default(1),
                    ]),
                ]),

            Forms\Components\Section::make('Details')->schema([
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->helperText('Optional — shown when the hotspot is clicked'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('project.title')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('label')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\ColorColumn::make('color')
                    ->label('Color'),

                Tables\Columns\TextColumn::make('position_x')
                    ->label('X')
                    ->numeric(3)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('position_y')
                    ->label('Y')
                    ->numeric(3)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('position_z')
                    ->label('Z')
                    ->numeric(3)
                    ->toggleable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'title')
                    ->searchable()
                    ->preload(),
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
            'index'  => Pages\ListModelHotspots::route('/'),
            'create' => Pages\CreateModelHotspot::route('/create'),
            'edit'   => Pages\EditModelHotspot::route('/{record}/edit'),
        ];
    }
}