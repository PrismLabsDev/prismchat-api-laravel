<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UseUuid
{
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->id = (string) Str::uuid();
    });
  }
}
