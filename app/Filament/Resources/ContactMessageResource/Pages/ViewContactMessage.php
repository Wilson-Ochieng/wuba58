<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Mail\ContactReplyFromAdmin;
use App\Models\ContactMessage;
use App\Models\ContactReply;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;
    protected static string $view = 'filament.resources.contact-message.view';

    public ?string $replyBody = '';

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Mark original as read + mark all inbound replies read
        $this->record->markAsRead();
        $this->record->replies()->where('direction', 'inbound')->update(['read_by_admin' => true]);
    }

    public function sendReply(): void
    {
        $this->validate([
            'replyBody' => ['required', 'string', 'min:2', 'max:5000'],
        ]);

        /** @var ContactMessage $msg */
        $msg = $this->record;

        $reply = ContactReply::create([
            'contact_message_id' => $msg->id,
            'direction'          => 'outbound',
            'body'               => $this->replyBody,
            'read_by_admin'      => true,
            'emailed_at'         => now(),
        ]);

        try {
            Mail::to($msg->email)->send(new ContactReplyFromAdmin($msg, $reply));

            Notification::make()
                ->title('Reply sent')
                ->body('Delivered to ' . $msg->email)
                ->success()
                ->send();
        } catch (\Throwable $e) {
            \Log::error('Admin reply mail failed: ' . $e->getMessage());

            Notification::make()
                ->title('Reply saved but email failed')
                ->body('Check the log. Error: ' . $e->getMessage())
                ->warning()
                ->send();
        }

        $msg->touchActivity();
        $this->replyBody = '';
        $this->record->refresh();
    }
}