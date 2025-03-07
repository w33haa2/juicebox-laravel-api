<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Console\Command;

class SendWelcomeEmailCommand extends Command
{
    protected $signature = 'user:send-welcome-email {email}';

    protected $description = 'Send a welcome email to a user using their email address';

    /**
     * Execute the console command. ( php artisan user:send-welcome-email user@example.com )
     */
    public function handle()
    {
        $email = $this->argument('email');

        // Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return;
        }

        // Dispatch the email job
        SendWelcomeEmailJob::dispatch($user);

        $this->info("Welcome email job dispatched for {$email}");
    }
}