<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrochureLeadResource\Pages;
use App\Models\BrochureLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BrochureLeadResource extends Resource
{
    protected static ?string $model = BrochureLead::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = 'Inbox';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Brochure Leads';
    protected static ?string $modelLabel = 'Brochure Lead';

    public static function getNavigationBadge(): ?string
    {
        $count = BrochureLead::unread()->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Lead')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('company')->disabled(),
                Forms\Components\Textarea::make('message')->rows(3)->disabled()->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Brochure')->schema([
                Forms\Components\TextInput::make('brochure.title')->label('Downloaded brochure')->disabled(),
                Forms\Components\TextInput::make('created_at')->label('Downloaded at')->disabled(),
                Forms\Components\TextInput::make('emailed_at')->label('Emailed at')->disabled(),
                Forms\Components\Toggle::make('is_read'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->label('')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('warning'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (BrochureLead $r) => $r->email),

                Tables\Columns\TextColumn::make('company')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('brochure.title')
                    ->label('Brochure')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Downloaded')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read'),
                Tables\Filters\SelectFilter::make('brochure_id')
                    ->label('Brochure')
                    ->relationship('brochure', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->after(fn (BrochureLead $record) => $record->markAsRead()),

                Tables\Actions\Action::make('reply')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->url(fn (BrochureLead $record) => 'mailto:' . $record->email . '?subject=Re: ' . $record->brochure->title)
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('mark_read')
                    ->icon('heroicon-o-check')
                    ->visible(fn (BrochureLead $record) => ! $record->is_read)
                    ->action(fn (BrochureLead $record) => $record->markAsRead()),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_read')
                        ->label('Mark as read')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->markAsRead()),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrochureLeads::route('/'),
            'view'  => Pages\ViewBrochureLead::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}