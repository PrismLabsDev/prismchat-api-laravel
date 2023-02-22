<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UseUuid;

class AuthRequest extends Model
{
  use UseUuid, HasFactory;

  protected $table = "auth_request";

  protected $fillable = [
    'public_key',
    'verification_string',
  ];
}
