<?php

namespace App\Http\Controllers;

use App\Mail\ContactReplyFromUser;
use App\Models\ContactMessage;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactThreadController extends Controller
{
    public function show(string $token)
    {
        $message = ContactMessage::where('token', $token)->firstOrFail();
        $message->touchActivity();

        return view('pages.contact-thread', [
            'msg' => $message,
            'replies' => $message->replies()->orderBy('created_at')->get(),
        ]);
    }

    public function store(Request $request, string $token)
    {
        $message = ContactMessage::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:2', 'max:3000'],
        ]);

        $reply = ContactReply::create([
            'contact_message_id' => $message->id,
            'direction'          => 'inbound',
            'body'               => $validated['body'],
            'read_by_admin'      => false,
        ]);

        $message->update([
            'is_read'          => false, // mark thread unread again so admin notices
            'last_activity_at' => now(),
        ]);

        // Notify the admin of the new reply
        try {
            Mail::to(config('mail.contact_recipient', config('mail.from.address')))
                ->send(new ContactReplyFromUser($message, $reply));
        } catch (\Throwable $e) {
            \Log::error('Reply notification failed: ' . $e->getMessage());
        }

        return redirect()->route('contact.thread', $token)->with('replied', true);
    }
}