<?php

namespace App\Console\Commands;

use App\Client;
use Illuminate\Console\Command;

class RevokeAnalyticsClientToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:token:revoke {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Revoke analytics client's token";

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

        if (is_null($client)) {
            $this->info("There is no such client as ${name}");
            return;
        }

        if (!$this->confirm("Do you really want to revoke token for ${name} ?")) {
            $this->info("Token was not revoked.");
            return;
        }

        $client->api_token = null;
        $client->save();
        $this->info("Client's ${name} token was revoked");
    }
}
