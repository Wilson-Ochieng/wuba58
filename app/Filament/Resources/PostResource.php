<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Blog Posts';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Post')->tabs([

                Forms\Components\Tabs\Tab::make('Content')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, Forms\Set $set) =>
                            $set('slug', \Str::slug($state)))
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('excerpt')
                        ->rows(3)
                        ->maxLength(500)
                        ->helperText('Short summary shown on the blog index')
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('body')
                        ->required()
                        ->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Meta')->schema([
                    Forms\Components\Select::make('post_category_id')
                        ->label('Category')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn($state, Forms\Set $set) =>
                                    $set('slug', \Str::slug($state))),
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->unique('post_categories', 'slug'),
                            Forms\Components\ColorPicker::make('color')->default('#ECB143'),
                        ]),

                    Forms\Components\TagsInput::make('tags')
                        ->placeholder('Add a tag')
                        ->splitKeys(['Tab', ',']),

                    Forms\Components\Toggle::make('featured')
                        ->label('Feature on blog index'),

                    Forms\Components\Toggle::make('published')
                        ->default(true),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->default(now()),

                    Forms\Components\TextInput::make('order')
                        ->numeric()
                        ->default(0),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Media')->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('hero')
                        ->collection('hero')
                        ->image()
                        ->imageEditor()
                        ->columnSpanFull(),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                        ->collection('gallery')
                        ->image()
                        ->multiple()
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
                    ->collection('hero')
                    ->conversion('thumb')
                    ->height(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->limit(40),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color(fn(Post $record) => 'gray')
                    ->searchable(),

                Tables\Columns\IconColumn::make('featured')->boolean(),

                Tables\Columns\IconColumn::make('published')->boolean(),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('M j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('post_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}