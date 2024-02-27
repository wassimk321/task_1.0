<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApiLogging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $requestId = (string) Str::uuid();
        Log::channel('requests')->info(json_encode([
            'headers' => $request->header(),
            'body' => $request->all()
        ]), [
            'request-id' => $requestId
        ]);

        Log::channel('requestsIPs')->critical('URL : (' . $request->path() . ') - RequestID : (' . $requestId . ') - RequestIP : (' . $request->ip() . ')');

        $response =  $next($request);
        $data = $response->getData(true);

        // Log response with info or error level based on status code
        if ($response->isSuccessful()) {
            Log::channel('responses')->info(json_encode($response), [
                'request-id'    => $requestId,
            ]);
        } else {
            $errorMessage = isset($data['message']) ? $data['message'] : 'unknown error';
            Log::channel('responses')->error(json_encode($response), [
                'request-id' => $requestId,
                'error-message' => $errorMessage,
            ]);
        }

        return $response;
    }
}
