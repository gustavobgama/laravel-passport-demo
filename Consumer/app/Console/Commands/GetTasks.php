<?php

namespace App\Console\Commands;

use App\GrantTypes\GrantType;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetTasks extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:get {--grant=password : The grant type used to get the tasks. Available options: password, client_credentials}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get tasks from Task API using different OAuth2 grants.';

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
        $grantType = $this->option('grant');
        $grant = resolve(GrantType::class, [$grantType]);

        $tasks = $this->getTasks($grant->getToken(), $grantType);
        if (empty($tasks)) {
            $this->error("Can't retrieve the tasks using the grant {$grantType}");
            return;
        }

        $this->info("The tasks are retrieved successfully, here is the list:");
        $headers = array_keys($tasks[0]);
        $this->table($headers, $tasks);
    }

    /**
     * Get the tasks resource.
     *
     * @param string $token
     * @param string $grant
     * @return array
     */
    protected function getTasks(string $token, string $grant): array
    {
        $client = resolve(Client::class);
        $configKey = "grant_{$grant}";
        $response = $client->get(config("oauth.{$configKey}.api_url"), [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ]
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
