<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideResource\Pages;
use App\Models\Slide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SlideResource extends Resource
{
    protected static ?string $model = Slide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Homepage Slider';
    protected static ?string $modelLabel = 'Slide';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Image')->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->helperText('Recommended: 2400×1350 (16:9). Full-width background.')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Caption')->schema([
                Forms\Components\TextInput::make('title')
                    ->maxLength(150)
                    ->placeholder('Westlands Tower'),

                Forms\Components\TextInput::make('subtitle')
                    ->maxLength(200)
                    ->placeholder('1:200 illuminated sales model'),

                Forms\Components\TextInput::make('location')
                    ->maxLength(150)
                    ->placeholder('Nairobi, Kenya'),

                Forms\Components\TextInput::make('scale')
                    ->maxLength(20)
                    ->placeholder('1:200'),
            ])->columns(2),

            Forms\Components\Section::make('Call to action')->schema([
                Forms\Components\Select::make('cta_type')
                    ->options([
                        'project'  => 'Link to a project (use URL)',
                        'external' => 'External URL',
                        'whatsapp' => 'WhatsApp chat',
                        'email'    => 'Email',
                        'none'     => 'No button',
                    ])
                    ->default('project')
                    ->required()
                    ->native(false)
                    ->live(),

                Forms\Components\TextInput::make('link_url')
                    ->label('URL')
                    ->url()
                    ->maxLength(255)
                    ->visible(fn (Forms\Get $get) => in_array($get('cta_type'), ['project', 'external']))
                    ->helperText('e.g. /work/westlands-tower'),

                Forms\Components\TextInput::make('link_label')
                    ->label('Button label')
                    ->maxLength(50)
                    ->placeholder('View project')
                    ->helperText('Leave blank for the default "View project"'),
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
                Tables\Columns\TextColumn::make('order')->sortable()->width('60px'),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image')
                    ->height(60),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->weight('bold')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('location')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\BadgeColumn::make('cta_type')
                    ->colors([
                        'primary' => 'project',
                        'info'    => 'external',
                        'success' => 'whatsapp',
                        'warning' => 'email',
                        'gray'    => 'none',
                    ]),

                Tables\Columns\IconColumn::make('published')->boolean(),
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
            'index'  => Pages\ListSlides::route('/'),
            'create' => Pages\CreateSlide::route('/create'),
            'edit'   => Pages\EditSlide::route('/{record}/edit'),
        ];
    }
}