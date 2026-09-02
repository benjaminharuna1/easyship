<?php

namespace App\Services;

use App\Models\Geocache;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class GeocodingService
{
    /**
     * Get coordinates for a place, using the local cache first and
     * falling back to the LocationIQ geocoding API.
     *
     * @return array{lat: string, lon: string}|null
     */
    public function getCoordinates(string $place): ?array
    {
        $place = trim($place);
        if ($place === '') {
            return null;
        }

        $cached = Geocache::where('place', $place)->first();
        if ($cached) {
            return ['lat' => $cached->lat, 'lon' => $cached->lon];
        }

        $apiKey = Setting::find(1)?->geocode_api_key;
        if (empty($apiKey)) {
            return ['error' => 'Geocode API key is not configured.'];
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                ->get('https://us1.locationiq.com/v1/search.php', [
                    'key' => $apiKey,
                    'q' => $place,
                    'format' => 'json',
                    'limit' => 1,
                    'addressdetails' => 0,
                    'accept-language' => 'en',
                ]);

            if (!$response->successful()) {
                return ['error' => "API request failed with HTTP status {$response->status()}."];
            }

            $data = $response->json();
            if (empty($data) || !isset($data[0]['lat'], $data[0]['lon'])) {
                return ['error' => "Geocoding service could not find coordinates for the location: '$place'."];
            }

            $lat = $data[0]['lat'];
            $lon = $data[0]['lon'];

            Geocache::updateOrCreate(['place' => $place], ['lat' => $lat, 'lon' => $lon]);

            return ['lat' => $lat, 'lon' => $lon];
        } catch (\Exception $e) {
            return ['error' => 'Geocoding request failed.'];
        }
    }
}
