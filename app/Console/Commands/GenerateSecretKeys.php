<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSecretKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:generate-secret-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate 3 random secret keys and save them to .env';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Generate random keys
        $key1 = Str::random(32);
        $key2 = Str::random(32);
        $key3 = Str::random(32);

        // Define the keys
        $keys = [
            'SECURE_REQUEST_KEY' => $key1,
            'SECURE_DATA_KEY' => $key2,
            'SECURE_API_KEY' => $key3,
        ];

        // Update .env file
        foreach ($keys as $key => $value) {
            $this->updateEnvironmentVariable($key, $value);
        }

        // Display the keys in the console
        $this->info('Secret keys have been generated and saved to .env:');
        foreach ($keys as $key => $value) {
            $this->line("$key=$value");
        }
    }

    /**
     * Update or add an environment variable in the .env file.
     */
    protected function updateEnvironmentVariable(string $key, string $value)
    {
        $envPath = base_path('.env');
        $content = file_get_contents($envPath);

        // Check if the key exists in the .env file
        if (preg_match("/^{$key}=.*/m", $content)) {
            // Update the existing key
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        } else {
            // Append the new key
            $content .= "\n{$key}={$value}";
        }

        // Save the updated content back to the .env file
        file_put_contents($envPath, $content);
    }
}
