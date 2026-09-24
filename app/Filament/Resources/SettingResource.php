<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('key')->required()->unique(ignoreRecord: true)
                ->helperText('e.g. contact.whatsapp, contact.phone, contact.email, hero.headline'),
            Forms\Components\Select::make('group')->options([
                'general' => 'General',
                'contact' => 'Contact',
                'homepage' => 'Homepage',
                'social' => 'Social',
            ])->default('general')->native(false),
            Forms\Components\Select::make('type')->options([
                'text' => 'Text',
                'textarea' => 'Textarea',
                'boolean' => 'Boolean',
                'image' => 'Image URL',
                'url' => 'URL',
            ])->default('text')->native(false),

            Forms\Components\Textarea::make('value')
                ->rows(4)->columnSpanFull()
                ->visible(fn(Forms\Get $get) => in_array($get('type'), ['textarea', 'text', 'url', 'image'])),
            Forms\Components\Toggle::make('value')
                ->visible(fn(Forms\Get $get) => $get('type') === 'boolean'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('group')->badge()->sortable(),
            Tables\Columns\TextColumn::make('key')->searchable()->copyable(),
            Tables\Columns\TextColumn::make('value')->limit(50)->toggleable(),
            Tables\Columns\TextColumn::make('updated_at')->since()->toggleable(),
        ])
            ->defaultSort('group')
            ->filters([
                Tables\Filters\SelectFilter::make('group')->options([
                    'general' => 'General',
                    'contact' => 'Contact',
                    'homepage' => 'Homepage',
                    'social' => 'Social',
                ])
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}