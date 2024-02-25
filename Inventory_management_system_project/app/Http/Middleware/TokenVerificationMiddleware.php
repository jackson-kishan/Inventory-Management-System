<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try { 
            $token = $request->cookie('token');
            $result = JWTToken::VerifyToken($token); 
    
            if($result == 'unauthorized') {
                return redirect('/userLogin');
                // return response()->json([
                //     'status' => 'failed',
                //     'message' => 'unauthorized',
                // ]);
            } else {
               $request->header->set('email', $result->userEmail);
               $request->header->set('id', $result->userID);
                return $next($request);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Ooops! Something went wrong',
            ]);
        }

      

    }
}
