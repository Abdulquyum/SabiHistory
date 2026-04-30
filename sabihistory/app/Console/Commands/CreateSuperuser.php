<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateSuperuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a superuser (admin) account interactively';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Creating a new superuser account.');
        $this->newLine();

        // Prompt for name
        $name = $this->ask('Name');

        // Prompt for email with uniqueness check
        $email = $this->ask('Email');

        $emailValidator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email', 'unique:users,email']]
        );

        if ($emailValidator->fails()) {
            $this->error('Error: ' . $emailValidator->errors()->first('email'));
            return self::FAILURE;
        }

        // Prompt for password with confirmation
        $password = $this->secret('Password');
        $passwordConfirmation = $this->secret('Confirm password');

        if ($password !== $passwordConfirmation) {
            $this->error('Error: Passwords do not match.');
            return self::FAILURE;
        }

        $passwordValidator = Validator::make(
            ['password' => $password],
            ['password' => ['required', 'min:8']]
        );

        if ($passwordValidator->fails()) {
            $this->error('Error: ' . $passwordValidator->errors()->first('password'));
            return self::FAILURE;
        }

        // Create the superuser
        $user = User::create([
            'name'              => $name,
            'email'             => $email,
            'password'          => Hash::make($password),
            'role'              => 'admin',
            'is_admin'          => true,
            'email_verified_at' => now(),
        ]);

        $this->newLine();
        $this->info("Superuser \"{$user->name}\" ({$user->email}) created successfully.");

        return self::SUCCESS;
    }
}
