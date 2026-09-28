<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip non-GET, admin, login, api — BEFORE running the request
        if (! $request->isMethod('GET')
            || $request->is('admin*')
            || $request->is('login*')
            || $request->is('api/*')
            || $request->is('livewire/*')
            || $request->is('_ignition/*')) {
            return $next($request);
        }

        $response = $next($request);

        // Only track HTML responses
        if (! str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
            return $response;
        }

        // Don't track 4xx/5xx responses
        if ($response->getStatusCode() >= 400) {
            return $response;
        }

        try {
            PageView::create([
                'path'        => '/' . ltrim($request->path(), '/'),
                'route_name'  => $request->route()?->getName(),
                'referrer'    => $request->headers->get('referer'),
                'user_agent'  => substr((string) $request->userAgent(), 0, 500),
                'device_type' => PageView::detectDevice($request->userAgent()),
                'ip_hash'     => hash('sha256', $request->ip() . config('app.key')),
                'user_id'     => auth()->id(),
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Page view tracking failed: ' . $e->getMessage());
        }

        return $response;
    }
}