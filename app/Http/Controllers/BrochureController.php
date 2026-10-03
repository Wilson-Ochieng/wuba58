<?php

namespace App\Http\Controllers;

use App\Mail\BrochureDelivery;
use App\Models\Brochure;
use App\Models\BrochureLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BrochureController extends Controller
{
    public function index()
    {
        $brochures = Brochure::published()
            ->orderBy('order')
            ->get();

        return view('pages.brochures.index', compact('brochures'));
    }

    public function show(string $slug)
    {
        $brochure = Brochure::published()->where('slug', $slug)->firstOrFail();

        return view('pages.brochures.show', compact('brochure'));
    }

    public function request(Request $request)
    {
        $validated = $request->validate([
            'brochure_id' => ['required', 'exists:brochures,id'],
            'name'        => ['required', 'string', 'min:2', 'max:100'],
            'email'       => ['required', 'email:rfc', 'max:150'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'company'     => ['nullable', 'string', 'max:150'],
            'message'     => ['nullable', 'string', 'max:1000'],
        ]);

        $brochure = Brochure::published()->findOrFail($validated['brochure_id']);

        $lead = BrochureLead::create([
            'brochure_id' => $brochure->id,
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'] ?? null,
            'company'     => $validated['company'] ?? null,
            'message'     => $validated['message'] ?? null,
            'ip_address'  => $request->ip(),
            'user_agent'  => substr((string) $request->userAgent(), 0, 255),
        ]);

        // Send the brochure to the user
        try {
            Mail::to($lead->email)->send(new BrochureDelivery($brochure, $lead));
            $lead->update(['emailed_at' => now()]);
        } catch (\Throwable $e) {
            \Log::error('Brochure delivery mail failed: ' . $e->getMessage());
        }

        $brochure->increment('download_count');

        return redirect()
            ->route('brochures.thanks', $brochure->slug)
            ->with('lead_name', $lead->name);
    }

    public function thanks(string $slug)
    {
        $brochure = Brochure::published()->where('slug', $slug)->firstOrFail();

        return view('pages.brochures.thanks', compact('brochure'));
    }
}