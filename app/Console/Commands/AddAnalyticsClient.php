<?php

namespace App\Console\Commands;

use App\Client;
use App\Client\Token;
use Illuminate\Console\Command;

class AddAnalyticsClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:add {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add analytics client';

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
        $name = $this->argument('name');
        $client = Client::where('name', $name)->first();

        if (!is_null($client)) {
            $this->info("Client ${name} has already been created");
            return;
        }

        Client::create([
            'name' => $this->argument('name'),
            'api_token' => Token::generateToken()
        ]);

        $this->info("Client ${name} has been created");
    }
}
