<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\EncryptRequestResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EncryptRequestResponseMiddleware
{
    private $encrypt;

    public function __construct()
    {
        $this->encrypt = EncryptRequestResponse::make();
    }

    /**
     * Modifikasi Request: Dekripsi payload dan tambahkan ke Request.
     */
    private function modifyRequest(Request $request): void
    {
        if (!$request->has('payload')) {
            return; // Jika payload tidak ada, lanjutkan tanpa modifikasi
        }

        try {
            // Dekripsi payload
            $decrypted = $this->encrypt->decrypt($request->input('payload'));

            if (is_array($decrypted)) {
                // Gabungkan data didekripsi ke dalam request
                $request->merge($decrypted);
                $request->replace($request->except('payload')); // Hapus payload asli
            }
        } catch (\Exception $e) {
            // Jika dekripsi gagal, log error (opsional) dan abaikan
            logger()->error('Failed to decrypt payload: ' . $e->getMessage());
        }
    }

    /**
     * Modifikasi Response: Enkripsi bagian data dalam response.
     */
    private function modifyResponse(JsonResponse $response): void
    {
        try {
            $content = json_decode($response->getContent(), true);

            if (isset($content['data'])) {
                // Enkripsi bagian data dari response
                $content['data'] = $this->encrypt->encrypt($content['data']);
                $response->setContent(json_encode($content));
            }
        } catch (\Exception $e) {
            // Jika enkripsi gagal, log error (opsional) dan lanjutkan tanpa modifikasi
            logger()->error('Failed to encrypt response: ' . $e->getMessage());
        }
    }

    /**
     * Handle method: Modifikasi request sebelum dan response sesudah.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            config('app.env') === "local" &&
            $request->header('x-bypass')
        ) return $next($request);

        // Modifikasi Request
        $this->modifyRequest($request);

        // // Panggil middleware berikutnya
        $response = $next($request);

        // Modifikasi Response jika berupa JsonResponse
        if ($response instanceof JsonResponse) {
            $this->modifyResponse($response);
        }

        return $response;
    }
}
