<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class DocumentDownloadController extends Controller
{
    /**
     * Obtiene access token usando refresh_token guardado en config/services.php
     * (mismo método que usas en ArchivoController).
     */
    protected function getAccessToken(): string
    {
        $client_id = config('services.google.client_id');
        $client_secret = config('services.google.client_secret');
        $refresh_token = config('services.google.refresh_token');

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type'    => 'refresh_token',
        ]);

        if ($response->failed()) {
            Log::error('Google token error: ' . $response->body());
            throw new \RuntimeException('No se pudo obtener token de Google.');
        }

        $data = $response->json();
        return $data['access_token'] ?? throw new \RuntimeException('Access token no disponible.');
    }

    /**
     * Stream para PDF.js / visor.
     * Ruta sugerida: GET /view-pdf/{fileId}/download
     */
    public function downloadById(string $fileId): StreamedResponse
    {
        try {
            $accessToken = $this->getAccessToken();


            // Primero obtener metadata (mimeType, name)
            $metaResp = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get("https://www.googleapis.com/drive/v3/files/{$fileId}?fields=name,mimeType");

            if ($metaResp->failed()) {
                Log::error('Drive metadata error: ' . $metaResp->body());
                abort(404, 'No se encontró el archivo o no hay permisos.');
            }

            $meta = $metaResp->json();
            $mime = $meta['mimeType'] ?? 'application/pdf';
            $name = $meta['name'] ?? $fileId;

            // Si es un Google Doc (Drive native), usar export a PDF
            if (str_starts_with($mime, 'application/vnd.google-apps')) {
                $url = "https://www.googleapis.com/drive/v3/files/{$fileId}/export?mimeType=application/pdf";
                $responseMime = 'application/pdf';
            } else {
                // archivo binario (pdf u otro). En el caso de PDF devolvemos tal cual
                $url = "https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media";
                $responseMime = $mime;
            }

            // Hacer streaming desde Google (evitar cargar todo en memoria)
            $streamResp = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->withOptions(['stream' => true])->get($url);

            if ($streamResp->failed()) {
                Log::error('Drive download error: ' . $streamResp->body());
                abort(500, 'No se pudo descargar el archivo desde Drive.');
            }

            $body = $streamResp->getBody();

            return new StreamedResponse(function () use ($body) {
                while (! $body->eof()) {
                    echo $body->read(1024 * 64);
                    flush();
                }
            }, 200, [
                'Content-Type' => $responseMime,
                'Content-Disposition' => 'inline; filename="' . addslashes($name) . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
            ]);
        } catch (\Throwable $e) {
            Log::error('downloadById error: ' . $e->getMessage());
            abort(500, 'Error al obtener el archivo.');
        }
    }
}