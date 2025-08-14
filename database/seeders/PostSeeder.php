<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        $posts = [
            [
                'title' => 'First Post',
                'content' => 'This is the content of the first post. Welcome to our blog!',
                'status' => 'published',
                'published_at' => now(),
                'user_id' => $users->first()->id,
            ],
            [
                'title' => 'Second Post',
                'content' => 'This is the content of the second post. Another great article!',
                'status' => 'published',
                'published_at' => now(),
                'user_id' => $users->first()->id,
            ],
            [
                'title' => 'Third Post',
                'content' => 'This is the content of the third post. More interesting content here!',
                'status' => 'published',
                'published_at' => now(),
                'user_id' => $users->first()->id,
            ],
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }
    }
}
