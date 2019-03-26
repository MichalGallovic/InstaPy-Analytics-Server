<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminAcount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:create_admin {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $username = 'admin';

        $admin = User::where('name', $username)->first();

        if (!is_null($admin)) {
            $this->info("${username} has already been created");
            return;
        }

        $password = $this->secret("What should be the password?");

        if (strlen($password) < 8) {
            $this->info("Password must be at least 8 characters long");
            return;
        }

        User::create([
            'name' => "Admin",
            'username' => $username,
            'email' => $this->argument('email') ?? "",
            'password' => Hash::make($password),
        ]);

        $this->info("${username} has been created");
    }
}
