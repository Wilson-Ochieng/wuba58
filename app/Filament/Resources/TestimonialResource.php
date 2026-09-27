<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationLabel = 'Testimonials';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Author')->schema([
                Forms\Components\TextInput::make('author_name')
                    ->required()
                    ->maxLength(150),

                Forms\Components\TextInput::make('author_role')
                    ->maxLength(150)
                    ->placeholder('Director'),

                Forms\Components\TextInput::make('author_company')
                    ->maxLength(150)
                    ->placeholder('Vantage Properties'),

                Forms\Components\TextInput::make('author_avatar_url')
                    ->url()
                    ->maxLength(500)
                    ->helperText('Optional — Google review photo URL or a headshot URL'),
            ])->columns(2),

            Forms\Components\Section::make('Review')->schema([
                Forms\Components\Textarea::make('body')
                    ->required()
                    ->rows(5)
                    ->maxLength(1500)
                    ->columnSpanFull(),

                Forms\Components\Select::make('rating')
                    ->options([1 => '1 star', 2 => '2 stars', 3 => '3 stars', 4 => '4 stars', 5 => '5 stars'])
                    ->default(5)
                    ->required()
                    ->native(false),

                Forms\Components\Select::make('source')
                    ->options([
                        'manual' => 'Manual entry',
                        'google' => 'Google Reviews',
                    ])
                    ->default('manual')
                    ->required()
                    ->live()
                    ->native(false),

                Forms\Components\TextInput::make('source_url')
                    ->url()
                    ->maxLength(500)
                    ->visible(fn (Forms\Get $get) => $get('source') === 'google'),

                Forms\Components\DateTimePicker::make('reviewed_at')
                    ->default(now()),
            ])->columns(2),

            Forms\Components\Section::make('Display')->schema([
                Forms\Components\Toggle::make('featured')
                    ->label('Feature on homepage')
                    ->default(false),

                Forms\Components\Toggle::make('published')
                    ->default(true),

                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width('60px'),

                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->label('★'),

                Tables\Columns\TextColumn::make('author_name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Testimonial $r) => $r->author_company),

                Tables\Columns\TextColumn::make('body')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->body),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state) . str_repeat('☆', 5 - $state))
                    ->color('warning'),

                Tables\Columns\BadgeColumn::make('source')
                    ->colors([
                        'gray' => 'manual',
                        'primary' => 'google',
                    ]),

                Tables\Columns\IconColumn::make('published')
                    ->boolean(),

                Tables\Columns\TextColumn::make('reviewed_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                Tables\Filters\SelectFilter::make('source')->options([
                    'manual' => 'Manual',
                    'google' => 'Google',
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
            'index'  => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit'   => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }


    protected function getHeaderActions(): array
{
    return [
        \Filament\Actions\Action::make('sync_google')
            ->label('Sync Google Reviews')
            ->icon('heroicon-o-arrow-path')
            ->action(function () {
                $service = new \App\Services\GoogleReviewsService();
                if (! $service->isConfigured()) {
                    \Filament\Notifications\Notification::make()
                        ->title('Google Places API not configured')
                        ->body('Add GOOGLE_PLACES_API_KEY and GOOGLE_PLACE_ID to your .env')
                        ->warning()
                        ->send();
                    return;
                }
                $count = $service->sync();
                \Filament\Notifications\Notification::make()
                    ->title("Synced {$count} reviews")
                    ->body('New reviews are unpublished — review and publish them.')
                    ->success()
                    ->send();
            }),

        \Filament\Actions\CreateAction::make(),
    ];
}
}