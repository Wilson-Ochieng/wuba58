<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrochureResource\Pages;
use App\Models\Brochure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrochureResource extends Resource
{
    protected static ?string $model = Brochure::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'E-Brochures';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Brochure')->schema([
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
                        'general'     => 'General',
                    ])
                    ->native(false),

                Forms\Components\Textarea::make('description')
                    ->rows(4)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('File')->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('file')
                    ->collection('file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(51200)   // 50MB
                    ->required()
                    ->helperText('PDF only. Max 50MB.')
                    ->columnSpanFull(),

                Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->image()
                    ->imageEditor()
                    ->helperText('Optional cover image for the listing card')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Display')->schema([
                Forms\Components\Toggle::make('published')->default(true),
                Forms\Components\TextInput::make('order')->numeric()->default(0),
                Forms\Components\Placeholder::make('download_count_display')
                    ->label('Downloads')
                    ->content(fn ($record) => $record ? $record->download_count : 0),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')->sortable()->width('60px'),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')
                    ->height(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'primary' => 'residential',
                        'success' => 'commercial',
                        'warning' => 'masterplan',
                        'danger'  => 'mixed_use',
                        'gray'    => 'general',
                    ]),

                Tables\Columns\TextColumn::make('download_count')
                    ->label('Downloads')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('leads_count')
                    ->counts('leads')
                    ->label('Leads')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('published')->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')->options([
                    'residential' => 'Residential',
                    'commercial'  => 'Commercial',
                    'masterplan'  => 'Masterplan',
                    'mixed_use'   => 'Mixed Use',
                    'general'     => 'General',
                ]),
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
            'index'  => Pages\ListBrochures::route('/'),
            'create' => Pages\CreateBrochure::route('/create'),
            'edit'   => Pages\EditBrochure::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}