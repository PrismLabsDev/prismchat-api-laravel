<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {

    if ($request->hasHeader('Authorization') && $request->bearerToken() !== "") {

      try {
        $jwt = $request->bearerToken();
        $jwtPublicKey = sodium_bin2base64(sodium_crypto_sign_publickey(sodium_base642bin(config("auth.keypair_jwt"), SODIUM_BASE64_VARIANT_ORIGINAL)), SODIUM_BASE64_VARIANT_ORIGINAL);
        $decoded = JWT::decode($jwt, new Key($jwtPublicKey, 'EdDSA'));
        $decodedArray = json_decode(json_encode($decoded), true);

        $request['user_pubkey'] = $decodedArray['aud'];

        return $next($request);
      } catch (\exception $e) {
        Log::error($e);
        return response([
          'message' => 'Error.',
        ], 500);
      }
    } else {
      return response([
        'message' => 'No Authorization header found.'
      ], 401);
    }
  }
}
