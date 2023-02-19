<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\UseUuid;

class Message extends Model
{
  use UseUuid, HasFactory;

  protected $table = "messages";

  protected $fillable = [
    'recipient',
    'message',
  ];
}
