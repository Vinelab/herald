# Sr. Backend Engineer – Coding Skill Assessment
### Objective

The purpose of this assessment is to evaluate your understanding of PHP OOP & Laravel. Focusing on the aspects of Inversion of Control, Unit Testing and Data Transfer Objects (DTOs).

**Herald** is a Laravel application that fetches data from several API endpoints, reformats them into a proprietary format and publishes them into a RabbitMQ queue. However, its tests are currently failing, and we need your help to have them pass! And one more addition to its feature set.

### Pull Code

1. Go to [https://github.com/vinelab/herald](https://github.com/vinelab/herald)
2. Fork the repository to your account
3. Clone the forked repository to begin 

**Info**

* Laravel version: ^9.19
* PHP version: 8.1 (present in the container using Laravel Sail)

There are two files to be used as a starting point: `app/Console/Commands/FetchCreatorInsights.php `and `tests/Feature/FetchCreatorInsightsTest.php`.

### Running Tests

The application uses [Laravel Sail](https://laravel.com/docs/9.x/sail) so you could simply use `sail up -d` to launch the container and `sail shell` to grab a terminal session and run the test with

```bash
php artisan test --filter FetchCreatorInsightsTest
```

The test incorporates mocking of HTTP calls and queue interaction in order to keep the test local. This means that you won’t need RabbitMQ installed or any prior RBMQ knowledge since the test mocks the connection and replaces it with an expectation.

When you first pull the repo and run the test, it is normal to get an error and for the test not to pass, more details on that in the tasks below.

### Tasks
#### 1. Fix The Test

It is time to squash those bugs! 🐞 The test’s expectation has an additional `mentions` field that isn’t present in the application logic for posts. However, this is not the only thing that’s wrong with the test and something else needs to be fixed before you get to this one, and we’ll leave it to you to figure that out! 😉

_P.S. if you see the following error when you run the test, that’s expected, and is what needs fixing._

```
stream_socket_client(): Unable to connect to tcp://localhost:5672 (Cannot assign requested address)
```

#### 2. Add `LookalikesCollection&lt;Lookalike>` to `AudienceInsights`

`LookalikesCollection` is a collection that carries instances of `Lookalike` objects that you need to create and add to the `AudienceInsights` object. A Lookalike object has the following properties:

* `platform_id`: string -> retrieved from `user_id`
* `username`: string -> retrieved from `username`
* external_url: string -> retrieved from `url`

Below is the full API response for audience insights:

```json
{
    "user_profile": {
        "followers": 786543678,
        "commercial_posts": [
            {
                "post_id": "5d74ea50-fa83-456d-aec0-2fc9b10c6e3c",
                "caption": "Both average audiences at what little textile privilege me.",
                "stat": {
                    "likes": 320181219,
                    "views": 381084731,
                    "comments": 412294341
                }
            },
            {
                "post_id": "9d085ff1-ab58-3a7a-a5e0-a1445cf2af0a",
                "caption": "Recusandae magni rerum quia aut fugit nobis suscipit inventore.",
                "stat": {
                    "likes": 2304314,
                    "views": 201096481,
                    "comments": 418938238
                }
            },
            {
                "post_id": "80aa6673-34b4-39c5-9342-b1ca9c13f414",
                "caption": "Aliquid in aliquam consequatur.",
                "stat": {
                    "likes": 237498107,
                    "views": 959715074,
                    "comments": 741076808
                }
            }
        ]
    },
    "audience_followers": {
        "audience_lookalikes": [
            {
                "used_id": "abc2758a-4e16-367d-8cc8-704ad96a9cae",
                "username": "fmayer",
                "url": "https://fake.url/fmayer"
            },
            {
                "used_id": "6c0c5fc4-dc8b-3b36-8ee3-a911ab9b4807",
                "username": "langosh.ona",
                "url": "https://fake.url/langosh.ona"
            },
            {
                "used_id": "b4f9d1a1-1772-3c7c-812c-0953406f113c",
                "username": "willy.kuhic",
                "url": "https://fake.url/willy.kuhic"
            }
        ]
    }
}
```

_Hint: See <code>PostsCollection&lt;Post></code> in <code>AudienceInsights</code> for reference.</em>_

# Submit Results

In order to submit your solution please do the following:

1. Create a new branch and push your solution to it
2. Open a Pull Request to the main branch
3. Invite us as collaborators to your forked repo:
    * mulkave ([https://github.com/mulkave](https://github.com/mulkave))
    * KinaneD ([https://github.com/kinaned](https://github.com/kinaned))

Happy coding and best of luck!
