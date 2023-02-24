<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeneratePublicKey extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'key:auth';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate public key used for authentication verification.';

  /**
   * Execute the console command.
   */
  public function handle(): void
  {
    $keyPair = sodium_crypto_box_keypair();

    echo ("COMBINED: " . sodium_bin2base64($keyPair, SODIUM_BASE64_VARIANT_ORIGINAL) . "\n");
    echo ("PUBLIC: " . sodium_bin2base64(sodium_crypto_box_publickey($keyPair), SODIUM_BASE64_VARIANT_ORIGINAL) . "\n");
    echo ("PRIVATE: " . sodium_bin2base64(sodium_crypto_box_secretkey($keyPair), SODIUM_BASE64_VARIANT_ORIGINAL) . "\n");
  }
}
