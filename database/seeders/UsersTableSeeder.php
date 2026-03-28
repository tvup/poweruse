<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credentialsFile = __DIR__ . '/user_credentials.json';

        if (!file_exists($credentialsFile)) {
            $this->command->warn('Skipping user seed: database/seeders/user_credentials.json not found.');
            $this->command->info('Copy user_credentials.json.example and fill in your credentials.');
            return;
        }

        $fileContents = file_get_contents($credentialsFile);
        if ($fileContents === false) {
            $this->command->error('Could not read database/seeders/user_credentials.json.');
            return;
        }
        $credentials = json_decode($fileContents, true);

        User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
            'refresh_token' => $credentials['refresh_token'] ?? env($credentials['refresh_token_env_key'] ?? ''),
            'smartme_username' => $credentials['smartme_username'] ?? null,
            'smartme_password' => $credentials['smartme_password'] ?? null,
            'smartme_directory_id' => $credentials['smartme_directory_id'] ?? null,
        ]);
    }
}
