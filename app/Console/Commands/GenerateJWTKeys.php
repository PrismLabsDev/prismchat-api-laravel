<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateJWTKeys extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'key:jwt';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate keys for JWT verification.';

  /**
   * Execute the console command.
   */
  public function handle(): void
  {
    $keyPair = sodium_crypto_sign_keypair();

    echo ("COMBINED: " . sodium_bin2base64($keyPair, SODIUM_BASE64_VARIANT_ORIGINAL) . "\n");
    echo ("PUBLIC: " . sodium_bin2base64(sodium_crypto_sign_publickey($keyPair), SODIUM_BASE64_VARIANT_ORIGINAL) . "\n");
    echo ("PRIVATE: " . sodium_bin2base64(sodium_crypto_sign_secretkey($keyPair), SODIUM_BASE64_VARIANT_ORIGINAL) . "\n");
  }
}
