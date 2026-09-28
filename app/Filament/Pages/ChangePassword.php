<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'My Password';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 3;
    protected static ?string $title = 'Change My Password';
    protected static string $view = 'filament.pages.change-password';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Update Password')
                    ->description('Choose a strong password. You will use this the next time you sign in.')
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Current password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->currentPassword()
                            ->autocomplete('current-password'),

                        Forms\Components\TextInput::make('password')
                            ->label('New password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->rule(Password::defaults())
                            ->confirmed()
                            ->minLength(8)
                            ->autocomplete('new-password'),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirm new password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->autocomplete('new-password'),
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        auth()->user()->update([
            'password' => Hash::make($data['password']),
        ]);

        // Clear the form
        $this->form->fill();

        Notification::make()
            ->title('Password updated')
            ->body('Your password has been changed successfully.')
            ->success()
            ->duration(5000)
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Update password')
                ->submit('submit')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function getTitle(): string
    {
        return 'Change My Password';
    }
}