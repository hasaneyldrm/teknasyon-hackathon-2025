<?php

namespace App\Http\Middleware;

use App\Models\IpBan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpBanCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        
        $ban = IpBan::where('ip_address', $ipAddress)
            ->where(function ($query) {
                $query->where('type', 'permanent')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if ($ban) {
            return response()->json([
                'error' => 'IP address banned',
                'message' => 'Access denied from this IP address',
                'reason' => $ban->reason
            ], 403);
        }

        return $next($request);
    }
}
