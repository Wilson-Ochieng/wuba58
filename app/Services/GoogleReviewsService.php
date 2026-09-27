<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleReviewsService
{
    protected string $apiKey;
    protected string $placeId;

    public function __construct()
    {
        $this->apiKey = config('services.google_places.key', '');
        $this->placeId = config('services.google_places.place_id', '');
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey) && ! empty($this->placeId);
    }

    /**
     * Fetch up to 5 reviews from Google Places API.
     * Google only ever returns 5 via the API — the rest require scraping or paid services.
     */
    public function fetch(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $this->placeId,
            'fields' => 'reviews,rating,user_ratings_total',
            'key' => $this->apiKey,
            'reviews_sort' => 'newest',
        ]);

        if (! $response->successful()) {
            Log::error('Google Places API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        return $response->json('result.reviews', []);
    }

    /**
     * Sync Google reviews into the testimonials table.
     * Deduplicates using external_id.
     */
    public function sync(): int
    {
        $reviews = $this->fetch();
        $count = 0;

        foreach ($reviews as $review) {
            if (empty($review['time'])) {
                continue;
            }

            // Google uses Unix timestamps for review time
            $externalId = md5($review['author_name'] . $review['time']);

            Testimonial::updateOrCreate(
                ['external_id' => $externalId],
                [
                    'author_name' => $review['author_name'] ?? 'Anonymous',
                    'author_avatar_url' => $review['profile_photo_url'] ?? null,
                    'body' => $review['text'] ?? '',
                    'rating' => $review['rating'] ?? 5,
                    'source' => 'google',
                    'source_url' => $review['author_url'] ?? null,
                    'reviewed_at' => \Carbon\Carbon::createFromTimestamp($review['time']),
                    'published' => false, // Manually approve before publishing
                ]
            );

            $count++;
        }

        return $count;
    }
}