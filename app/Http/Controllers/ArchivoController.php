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
        $file = TmFiles::find($id);
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

        return abort(404, 'Archivo no disponible.');
    }

}
