<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Mail\ContactReplyFromAdmin;
use App\Models\ContactMessage;
use App\Models\ContactReply;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Inbox';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Contact Messages';

    public static function getNavigationBadge(): ?string
    {
        // Unread = unread originals OR inbound replies awaiting admin
        $unread = ContactMessage::unread()->count()
            + ContactReply::where('direction', 'inbound')->where('read_by_admin', false)->count();
        return $unread > 0 ? (string) $unread : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        // Read-only form; all editing happens through custom actions
        return $form->schema([
            Forms\Components\Section::make('Contact Details')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('company')->disabled(),
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
                    ->description(fn(ContactMessage $r) => $r->email),

                Tables\Columns\TextColumn::make('project_type')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? ucfirst(str_replace('_', ' ', $state)) : '—'),

                Tables\Columns\TextColumn::make('message')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->message),

                Tables\Columns\TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('Replies')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('last_activity_at')
                    ->label('Last activity')
                    ->since()
                    ->sortable()
                    ->default(fn($record) => $record->created_at),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')->label('Read status'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('Open conversation')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url(fn(ContactMessage $r) => static::getUrl('view', ['record' => $r])),
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
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function canCreate(): bool
    {
        return false;
    }
}