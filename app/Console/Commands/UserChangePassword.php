<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserChangePassword extends Command
{
    protected $signature = 'user:change-password {email : The email of the user}';

    protected $description = 'Change the password for a user';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (!$user) {
            $this->error('User not found.');
            return self::FAILURE;
        }

        $this->info("Changing password for: {$user->name} ({$user->email})");

        $password = $this->secret('New password');
        $confirmation = $this->secret('Confirm password');

        if ($password !== $confirmation) {
            $this->error('Passwords do not match.');
            return self::FAILURE;
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters.');
            return self::FAILURE;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info('Password updated.');

        return self::SUCCESS;
    }
}
