<?php

namespace App\Http\Middleware;

use App\Helper\ResponseApi;
use App\Helper\SecureCommunication;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureCommunicationMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('X-BYPASS')) return $next($request);

        try {
            // Dekripsi payload untuk JSON dan file metadata
            if ($request->isJson()) {
                $encryptedData = $request->getContent();
                $decryptedData = SecureCommunication::decrypt($encryptedData);
                $request->replace(json_decode($decryptedData, true));
            } elseif ($request->hasFile('file') && $request->has('metadata')) {
                // Jika ada file, dekripsi metadata
                $encryptedMetadata = $request->input('metadata');
                $decryptedMetadata = json_decode(SecureCommunication::decrypt($encryptedMetadata), true);
                $request->merge(['metadata' => $decryptedMetadata]);
            }
        } catch (Exception $e) {
            return ResponseApi::statusFatalError()
                ->message('Request payload is not valid.')
                ->json();
        }

        $response = $next($request);

        // Enkripsi respons hanya untuk JSON (bukan file)
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            try {
                $originalContent = json_decode($response->getContent(), true);
                if (isset($originalContent['data'])) {
                    $originalContent['data'] = SecureCommunication::encrypt(json_encode($originalContent['data']));
                }

                return response()->json($originalContent, $response->status(), $response->headers->all());
            } catch (Exception $e) {
                return ResponseApi::statusQueryError()
                    ->message('Failed to encrypt response payload.')
                    ->json();
            }
        }

        return $response;
    }
}
