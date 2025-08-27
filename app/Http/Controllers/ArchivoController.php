<?php

namespace App\Http\Controllers;

use App\Models\TmFiles;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    private function token(){

        $client_id = \Config('services.google.client_id');
        $client_secret = \Config('services.google.client_secret');
        $refresh_token = \Config('services.google.refresh_token');
        $response = Http::post('https://oauth2.googleapis.com/token',[
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token'
        ]);

        $accessToken = json_decode((string)$response->getBody(),true)['access_token'];
        return $accessToken;
    }

    public function descargar($id)
    {
        /*$file = TmFiles::find($id);
        $accessToken = $this->token();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get("https://www.googleapis.com/drive/v3/files/{$file->drive_id}?alt=media");

        if ($response->successful()) {
            $fileName = $file->nombre;
            $filePath = 'archivos/' . $fileName;

            Storage::disk('public')->put($filePath, $response->body());

            return response()->download(storage_path('app/public/' . $filePath))->deleteFileAfterSend(true);
        }

        return abort(404, 'Archivo no disponible.');*/

        $file = TmFiles::find($id);

        if (!$file || !$file->drive_id) {
            return abort(404, 'Archivo no disponible.');
        }

        $accessToken = $this->token();

        // Obtener metadata para saber el tipo MIME real del archivo
        $metadataResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get("https://www.googleapis.com/drive/v3/files/{$file->drive_id}?fields=name,mimeType");

        if (!$metadataResponse->successful()) {
            return abort(404, 'No se pudo obtener la metadata del archivo.');
        }

        $mimeType = $metadataResponse['mimeType'];
        $baseName = pathinfo($file->nombre, PATHINFO_FILENAME);

        // Determinar la extensión basada en el tipo MIME
        $extension = match ($mimeType) {
            'application/pdf' => 'pdf',
            'application/msword' => 'doc', // Word clásico
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel',
            'application/vnd.ms-excel' => 'xls', // Excel clásico
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',

            // Videos
            'video/mp4' => 'mp4',
            'video/x-msvideo' => 'avi',   // AVI
            'video/x-matroska' => 'mkv',  // MKV
            'video/webm' => 'webm',

            default => 'bin',
        };

        $fileName = $baseName . '.' . $extension;
        $filePath = 'archivos/' . $fileName;

        // Descargar el archivo desde Google Drive
        $fileResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get("https://www.googleapis.com/drive/v3/files/{$file->drive_id}?alt=media");

        if (!$fileResponse->successful()) {
            return abort(404, 'No se pudo descargar el archivo desde Drive.');
        }

        // Guardar temporalmente el archivo en disco
        Storage::disk('public')->put($filePath, $fileResponse->body());

        // Enviar la descarga con headers personalizados
        return response()->download(storage_path('app/public/' . $filePath), $fileName, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ])->deleteFileAfterSend(true);
        }

}
