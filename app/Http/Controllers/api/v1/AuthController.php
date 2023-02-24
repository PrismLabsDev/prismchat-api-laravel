<?php

namespace App\Http\Controllers\api\v1;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuthRequest;

class AuthController extends Controller
{

  private function randomString($n)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
    }

    return $randomString;
  }

  public function test(Request $request)
  {
    // $request->validate([
    //   'pubkey' => ['required'],
    // ]);

    try {

      return response([
        'message' => 'Test Route',
        'userId' => $request['user_pubkey']
      ], 200);
    } catch (\exception $e) {
      Log::error($e);
      return response([
        'message' => 'Error.',
      ], 500);
    }
  }

  public function pubkey(Request $request)
  {
    // $request->validate([
    //   'pubkey' => ['required'],
    // ]);

    try {

      $authPublicKey = sodium_crypto_box_publickey(sodium_base642bin(config("auth.keypair_auth"), SODIUM_BASE64_VARIANT_ORIGINAL));

      return response([
        'message' => 'Server Public Key.',
        'pubkey' => sodium_bin2base64($authPublicKey, SODIUM_BASE64_VARIANT_ORIGINAL),
      ], 200);
    } catch (\exception $e) {
      Log::error($e);
      return response([
        'message' => 'Error.',
      ], 500);
    }
  }

  public function request(Request $request)
  {
    $request->validate([
      'pubkey' => ['required'],
    ]);

    try {

      // Generate new random verification string
      $verificationString = $this->randomString(rand(50, 60));

      // Remove existing requests
      AuthRequest::where('public_key', $request->pubkey)->delete();

      // Generate new request
      $newAuthRequest = new AuthRequest;
      $newAuthRequest->public_key = $request->pubkey;
      $newAuthRequest->verification_string = $verificationString;
      $newAuthRequest->save();

      // Get authentication key
      $authKeys = sodium_base642bin(config("auth.keypair_auth"), SODIUM_BASE64_VARIANT_ORIGINAL);
      $authPublicKey = sodium_bin2base64(sodium_crypto_box_publickey($authKeys), SODIUM_BASE64_VARIANT_ORIGINAL);

      return response([
        'message' => 'Requesting Authentication.',
        'serverPublicKey' => $authPublicKey,
        'verificationString' => $verificationString
      ], 200);
    } catch (\exception $e) {
      Log::error($e);
      return response([
        'message' => 'Error.',
      ], 500);
    }
  }

  public function verify(Request $request)
  {
    $request->validate([
      'pubkey' => ['required'],
      'cypher' => ['required'],
      'nonce' => ['required'],
    ]);

    try {

      // Validate auth request
      $verificationRequest = AuthRequest::where('public_key', $request->pubkey)->first();

      $authKeys = sodium_base642bin(config("auth.keypair_auth"), SODIUM_BASE64_VARIANT_ORIGINAL);
      $authPrivateKey = sodium_crypto_box_secretkey($authKeys);

      $cypher = sodium_base642bin($request->cypher, SODIUM_BASE64_VARIANT_ORIGINAL);
      $nonce = sodium_base642bin($request->nonce, SODIUM_BASE64_VARIANT_ORIGINAL);

      $boxKeyPair = sodium_crypto_box_keypair_from_secretkey_and_publickey($authPrivateKey, sodium_base642bin($verificationRequest->public_key, SODIUM_BASE64_VARIANT_ORIGINAL));

      $decryptedCypher = json_decode(sodium_crypto_box_open($cypher, $nonce, $boxKeyPair), true);

      if ($decryptedCypher['verificationString'] == $verificationRequest->verification_string) {
        // Generate JWT
        $jwtPrivateKey = sodium_bin2base64(sodium_crypto_sign_secretkey(sodium_base642bin(config("auth.keypair_jwt"), SODIUM_BASE64_VARIANT_ORIGINAL)), SODIUM_BASE64_VARIANT_ORIGINAL);

        $issuedAt = floor(microtime(true));
        $expireAt = floor($issuedAt + (1 * 60 * 60 * 24)); // millisecond, second, minute, hour, day

        $payload = [
          'iss' => "prism.chat",
          'aud' => $verificationRequest->public_key,
          'iat' => $issuedAt,
          'exp' => $expireAt,
        ];

        $jwt = JWT::encode($payload, $jwtPrivateKey, 'EdDSA');

        return response([
          'message' => 'Authentication Verified.',
          'access_token' => $jwt
        ], 200);
      } else {
        // Remove existing requests
        AuthRequest::where('public_key', $request->pubkey)->delete();

        return response([
          'message' => 'Verification string does not match.'
        ], 401);
      }
    } catch (\exception $e) {
      Log::error($e);
      return response([
        'message' => 'Error.',
      ], 500);
    }
  }
}
