<?php

namespace App\Http\Middleware;

use App\Models\RequestLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RequestLogging
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $responseTime = round(($endTime - $startTime) * 1000);
        
        $this->logRequest($request, $response, $responseTime);
        
        return $response;
    }

    private function logRequest(Request $request, Response $response, int $responseTime): void
    {
        try {
            $requestData = $this->sanitizeRequestData($request->all());
            
            RequestLog::create([
                'user_uuid' => $request->input('user_uuid') ?? $this->generateUserUuid($request),
                'project_id' => 1, // Default project for now
                'ip_address' => $request->ip(),
                'method' => $request->method(),
                'path' => $request->path(),
                'request_data' => $this->encodeLogData($requestData),
                'response_code' => $response->getStatusCode(),
                'response_data' => $this->encodeLogData($this->getResponseData($response)),
                'response_time' => $responseTime,
                'user_agent' => $this->sanitizeString($request->userAgent()),
                'action' => 'api_request',
                'error_message' => $response->getStatusCode() >= 400 ? $this->encodeLogData($this->getResponseData($response)) : null,
                'security_flags' => $this->getSecurityFlags($request, $response)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log request: ' . $e->getMessage());
        }
    }

    private function generateUserUuid(Request $request): string
    {
        // Generate a simple user identifier based on IP and User Agent
        $identifier = $request->ip() . '|' . ($request->userAgent() ?? 'unknown');
        return substr(md5($identifier), 0, 8) . '-' . 
               substr(md5($identifier), 8, 4) . '-' . 
               substr(md5($identifier), 12, 4) . '-' . 
               substr(md5($identifier), 16, 4) . '-' . 
               substr(md5($identifier), 20, 12);
    }

    private function getResponseData(Response $response): string
    {
        $content = $response->getContent();
        if (strlen($content) > 1000) {
            return substr($content, 0, 1000) . '... (truncated)';
        }
        return $content;
    }

    private function getSecurityFlags(Request $request, Response $response): array
    {
        $flags = [];

        // Check for security headers
        if ($request->hasHeader('X-API-Key')) {
            $flags['has_api_key'] = true;
        }
        
        // Check response status
        $flags['status_code'] = $response->getStatusCode();
        $flags['is_error'] = $response->getStatusCode() >= 400;

        // Check for suspicious activity
        $flags['ip_address'] = $request->ip();
        $flags['user_agent'] = $this->sanitizeString($request->userAgent());

        return $flags;
    }

    private function sanitizeRequestData(array $data): array
    {
        $sanitized = [];
        
        foreach ($data as $key => $value) {
            $sanitizedKey = $this->sanitizeString($key);
            
            if (is_string($value)) {
                $sanitized[$sanitizedKey] = $this->sanitizeString($value);
            } elseif (is_array($value)) {
                $sanitized[$sanitizedKey] = $this->sanitizeRequestData($value);
            } else {
                $sanitized[$sanitizedKey] = $value;
            }
        }
        
        return $sanitized;
    }

    private function sanitizeString(?string $input): string
    {
        if (!$input) return '';
        
        // HTML injection koruması
        $sanitized = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Limit length
        if (strlen($sanitized) > 500) {
            $sanitized = substr($sanitized, 0, 500) . '...';
        }
        
        return trim($sanitized);
    }

    private function encodeLogData($data): string
    {
        if (is_string($data)) {
            // Hassas verileri kontrol et
            if ($this->containsSensitiveData($data)) {
                return '***SENSITIVE_DATA***';
            }
            return $data;
        }
        
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function containsSensitiveData(string $data): bool
    {
        $sensitivePatterns = [
            '/password/i',
            '/token/i',
            '/key/i',
            '/secret/i',
            '/auth/i',
        ];
        
        foreach ($sensitivePatterns as $pattern) {
            if (preg_match($pattern, $data)) {
                return true;
            }
        }
        
        return false;
    }
}
