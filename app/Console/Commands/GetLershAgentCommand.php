<?php

namespace App\Console\Commands;

use App\Models\LershaAgent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetLershAgentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-lersh-agent-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'brings agent data from Lersha System';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //get lesha url and credentials from env
        $url = config('app.lersha.url');
        $username = config('app.lersha.username');
        $password = config('app.lersha.password');
        logger('URL: ' . $url);

        //login and get the token from Lersha System
        $response = Http::post($url . '/api/iam/login/jwt', [
            'username' => $username,
            'password' => $password,
        ]);

        $token = $response->json()['token'];

        //get agents from Lersha System

        $response = Http::withToken($token)->get($url . '/api/iam/la/all');

        $agents = $response->json();

        //save agents to the database
        foreach ($agents as $agent) {
            $agent = [
                'lersha_id' => $agent['id'],
                'first_name' => $agent['first_name'],
                'middle_name' => $agent['middle_name'],
                'last_name' => $agent['last_name'],
                'phone' => $agent['phone_number'],
            ];

            LershaAgent::updateOrCreate(['lersha_id' => $agent['lersha_id']], $agent);
        }
    }
}
