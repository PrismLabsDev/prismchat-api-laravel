<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuthRequest;

class AuthController extends Controller
{
  public function request(Request $request)
  {
    return response([
      'message' => 'Requesting Authentication.'
    ], 200);
  }

  public function verify(Request $request)
  {
    return response([
      'message' => 'Authentication Verified.'
    ], 200);
  }
}
