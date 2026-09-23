<?php

namespace App\Livewire;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Mail\ContactAutoReply;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;


class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $company = '';
    public string $project_type = '';
    public string $message = '';
    public string $website = '';   // honeypot field

    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'min:2', 'max:100'],
            'email'        => ['required', 'email:rfc', 'max:150'],
            'phone'        => ['nullable', 'string', 'max:30'],
            'company'      => ['nullable', 'string', 'max:150'],
            'project_type' => ['nullable', 'string', 'in:residential,commercial,masterplan,mixed_use,industrial,other'],
            'message'      => ['required', 'string', 'min:10', 'max:3000'],
        ];
    }

    public function updated($field): void
    {
        $this->validateOnly($field);
    }

  public function submit(): void
{
    // Honeypot
    if (! empty($this->website)) {
        abort(403);
    }

    $validated = $this->validate();

    $contactMessage = ContactMessage::create($validated + [
        'ip_address'       => request()->ip(),
        'user_agent'       => substr((string) request()->userAgent(), 0, 255),
        'last_activity_at' => now(),
    ]);

    // 1. Notify the admin
    try {
        Mail::to(config('mail.contact_recipient', config('mail.from.address')))
            ->send(new ContactMessageReceived($contactMessage));
    } catch (\Throwable $e) {
        \Log::error('Admin contact mail failed: ' . $e->getMessage());
    }

    // 2. Auto-reply to the sender
    try {
        Mail::to($contactMessage->email)
            ->send(new ContactAutoReply($contactMessage));
    } catch (\Throwable $e) {
        \Log::error('Auto-reply failed: ' . $e->getMessage());
    }

    $this->reset(['name', 'email', 'phone', 'company', 'project_type', 'message', 'website']);
    $this->sent = true;
}

    public function render()
    {
        return view('livewire.contact-form');
    }
}