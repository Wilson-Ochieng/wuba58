<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'FAQ';
    protected static ?string $modelLabel = 'FAQ';
    protected static ?string $pluralModelLabel = 'FAQ';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Question & Answer')->schema([
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('answer')
                    ->required()
                    ->rows(5)
                    ->maxLength(2000)
                    ->columnSpanFull()
                    ->helperText('Plain text. This gets included in Google FAQ schema.'),
            ]),

            Forms\Components\Section::make('Display')->schema([
                Forms\Components\Select::make('category')
                    ->options(Faq::categories())
                    ->default('general')
                    ->required()
                    ->native(false),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('featured')
                    ->label('Show on homepage'),

                Forms\Components\Toggle::make('published')
                    ->default(true),
            ])->columns(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('question')
                    ->searchable()
                    ->weight('bold')
                    ->limit(60)
                    ->wrap(),

                Tables\Columns\BadgeColumn::make('category')
                    ->formatStateUsing(fn ($state) => Faq::categories()[$state] ?? $state)
                    ->colors([
                        'gray'    => 'general',
                        'warning' => 'pricing',
                        'primary' => 'process',
                        'success' => 'materials',
                        'info'    => 'delivery',
                        'danger'  => 'support',
                    ]),

                Tables\Columns\IconColumn::make('featured')
                    ->label('★')
                    ->boolean(),

                Tables\Columns\IconColumn::make('published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(Faq::categories()),
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
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}