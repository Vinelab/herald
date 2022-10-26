<?php

namespace Tests\Feature;

use App\Entities\Account;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Mockery;
use PhpAmqpLib\Channel\AMQPChannel;
use Tests\TestCase;
use Vinelab\Bowler\Connection;
use Vinelab\Bowler\Producer;

class FetchCreatorInsightsTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_fetch_and_dispatch_creator_insights()
    {
        $account = $this->fakeAccount();
        $audience = $this->fakeAudience();

        // fake HTTP call
        Http::fake([
            'sample.account.url' => Http::response($account),
            'sample.audience.url' => Http::response($audience),
        ]);

        $mChannel = Mockery::mock(AMQPChannel::class);
        $mChannel->shouldReceive('exchange_declare');

        $mConnection = Mockery::mock(Connection::class);
        $mConnection->shouldReceive('getChannel')->once()->withNoArgs()->andReturn($mChannel);

        app()->instance(Connection::class, $mConnection);

        // mock queue producer
        $mProducer = Mockery::mock(Producer::class);
        $mProducer->shouldReceive('send')
            ->with($this->expectedInsights($account, $audience));
        app()->instance(Producer::class, $mProducer);

        // execute
        $result = Artisan::call('fetch:insights');

        $this->assertEquals(0, $result);
    }

    private function fakeAccount(): array
    {
        return [
            'username' => fake()->userName(),
            'user_id' => fake()->uuid(),
            'gender' => fake()->randomElement(['m', 'f']),
            'phone_numbers' => [fake()->phoneNumber(), fake()->phoneNumber(), fake()->phoneNumber()],
        ];
    }

    private function expectedAccount(array $fake): array
    {
        return [
            'username' => $fake['username'],
            'platform_id' => $fake['user_id'],
            'gender' => $fake['gender'],
            'phone_numbers' => $fake['phone_numbers'],
        ];
    }

    private function fakeAudience(): array
    {
        return [
            'user_profile' => [
                'followers' => fake()->numberBetween(1000, 999999999),
                'commercial_posts' => [
                    [
                        'post_id' => fake()->uuid(),
                        'caption' => fake()->sentence(),
                        'mentions' => fake()->userName(),
                        'stat' => [
                            'views' => fake()->numberBetween(1000, 999999999),
                            'likes' => fake()->numberBetween(1000, 999999999),
                            'comments' => fake()->numberBetween(1000, 999999999),
                        ]
                    ],
                    [
                        'post_id' => fake()->uuid(),
                        'caption' => fake()->sentence(),
                        'mentions' => fake()->userName(),
                        'stat' => [
                            'views' => fake()->numberBetween(1000, 999999999),
                            'likes' => fake()->numberBetween(1000, 999999999),
                            'comments' => fake()->numberBetween(1000, 999999999),
                        ]
                    ],
                    [
                        'post_id' => fake()->uuid(),
                        'caption' => fake()->sentence(),
                        'mentions' => fake()->userName(),
                        'stat' => [
                            'views' => fake()->numberBetween(1000, 999999999),
                            'likes' => fake()->numberBetween(1000, 999999999),
                            'comments' => fake()->numberBetween(1000, 999999999),
                        ]
                    ],
                ],
                "audience_followers" => [
                    "audience_lookalikes" => [
                        [
                            "user_id" => "abc2758a-4e16-367d-8cc8-704ad96a9cae",
                            "username" => "fmayer",
                            "url" => "https://fake.url/fmayer"
                        ],
                        [
                            "user_id" => "6c0c5fc4-dc8b-3b36-8ee3-a911ab9b4807",
                            "username" => "langosh.ona",
                            "url" => "https://fake.url/langosh.ona"
                        ],
                        [
                            "user_id" => "b4f9d1a1-1772-3c7c-812c-0953406f113c",
                            "username" => "willy.kuhic",
                            "url" => "https://fake.url/willy.kuhic"
                        ]
                    ]
                ]
            ],
        ];
    }

    private function expectedAudience(array $fake): array
    {
        $expected = [];
        $expected['global_audience_size'] = Arr::get($fake, 'user_profile.followers');

        foreach(Arr::get($fake, 'user_profile.commercial_posts') as $post) {
            $expected['posts'][] = [
                'id' => Arr::get($post, 'post_id'),
                'views' => Arr::get($post, 'stat.views'),
                'likes' => Arr::get($post, 'stat.likes'),
                'comments' => Arr::get($post, 'stat.comments'),
                'caption' => Arr::get($post, 'caption'),
                'mentions' => Arr::get($post, 'mentions'),
            ];
        }

        return $expected;
    }

    private function expectedInsights($account, $audience): string
    {
        return json_encode([
            'account' => $this->expectedAccount($account),
            'audience' => $this->expectedAudience($audience),
        ]);
    }
}
