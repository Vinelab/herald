<?php

namespace App\Console\Commands;

use App\Entities\Account;
use App\Entities\AudienceInsights;
use App\Entities\CreatorInsights;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Vinelab\Bowler\Connection;
use Vinelab\Bowler\Producer;

class FetchCreatorInsights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:insights';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve insights of a creator and publish the data to the queue.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $account = $this->account();
        $audience = $this->audience();

        $insights = CreatorInsights::make($account, $audience);

        $producer = new Producer(app(Connection::class));
        $producer->setup('reporting_exchange');
        $producer->send($insights->toJson());

        return Command::SUCCESS;
    }

    private function account(): Account
    {
        $response = Http::get('https://sample.account.url');

        return Account::make($response->json());
    }

    private function audience(): AudienceInsights
    {
        $response = Http::get('https://sample.audience.url');

        return AudienceInsights::make($response->json());
    }
}
