<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectCategoryResource\Pages;
use App\Models\ProjectCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectCategoryResource extends Resource
{
    protected static ?string $model = ProjectCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Project Categories';
    protected static ?string $modelLabel = 'Project Category';
    protected static ?string $pluralModelLabel = 'Project Categories';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                    $set('slug', \Str::slug($state))),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(100),

            Forms\Components\ColorPicker::make('color')
                ->default('#ECB143')
                ->label('Accent color')
                ->helperText('Used for the category badge on project cards'),

            Forms\Components\Textarea::make('description')
                ->rows(2)
                ->columnSpanFull(),

            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('published')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\ColorColumn::make('color'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('projects_count')
                    ->counts('projects')
                    ->label('Projects')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\IconColumn::make('published')
                    ->boolean(),

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
            'index'  => Pages\ListProjectCategories::route('/'),
            'create' => Pages\CreateProjectCategory::route('/create'),
            'edit'   => Pages\EditProjectCategory::route('/{record}/edit'),
        ];
    }
}