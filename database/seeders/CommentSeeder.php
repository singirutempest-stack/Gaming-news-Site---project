<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'guest')->first();
        $news = News::published()->take(15)->get()->values();

        foreach ($news as $index => $article) {
            Comment::updateOrCreate(
                ['news_id' => $article->id, 'user_id' => $user->id, 'body' => 'This story changed how I look at the current meta.'],
                ['is_approved' => $index % 3 !== 0]
            );
        }
    }
}
