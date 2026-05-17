<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('role', 'journalist')->first();
        $admin  = User::where('role', 'admin')->first();
        $categories = Category::all()->values();
        $localVideoPath = 'news/videos/local-gameplay-demo.webm';

        if (! Storage::disk('public')->exists($localVideoPath)) {
            Storage::disk('public')->put($localVideoPath, base64_decode($this->localDemoVideo()));
        }

        Storage::disk('public')->makeDirectory('news/images');

        $articles = [
            ['title' => 'Neon Arena Update Reworks Ranked Matchmaking',    'keywords' => 'gaming,esports'],
            ['title' => 'Starfall Odyssey Gets a Cinematic Story Trailer', 'keywords' => 'space,science'],
            ['title' => 'Cyber League Finals Set New Viewership Record',   'keywords' => 'esports,stadium'],
            ['title' => 'Patch Notes: Balance Changes Shake Up the Meta',  'keywords' => 'strategy,gaming'],
            ['title' => 'Indie Showcase Reveals Ten New Console Launches', 'keywords' => 'gaming,technology'],
            ['title' => 'How to Build a Strong Early Game Loadout',        'keywords' => 'gaming,equipment'],
            ['title' => 'Studio Confirms Crossplay for Mech Frontier',    'keywords' => 'robot,technology'],
            ['title' => 'Review: Ashen Circuit Blends Speed and Strategy', 'keywords' => 'racing,car'],
            ['title' => 'Major Publisher Opens New European Studio',       'keywords' => 'office,business'],
            ['title' => 'Esports Teams Announce Spring Roster Moves',      'keywords' => 'team,esports'],
            ['title' => 'Trailer Breakdown: Mythforge Awakening',          'keywords' => 'fantasy,magic'],
            ['title' => 'Beginner Guide: Resource Routes That Actually Work', 'keywords' => 'adventure,travel'],
            ['title' => 'Cloud Saves Arrive for Retro Vault Collection',   'keywords' => 'retro,vintage'],
            ['title' => 'Review: Drift Kings 2 Finds Its Rhythm',          'keywords' => 'car,racing'],
            ['title' => 'Industry Report Shows PC Sales Rising Again',     'keywords' => 'computer,technology'],
            ['title' => 'Five Tips for Surviving Nightmare Mode',          'keywords' => 'dark,horror'],
            ['title' => 'Battle Royale Event Adds Limited Time Bosses',    'keywords' => 'battle,warrior'],
            ['title' => 'Speedrun Community Crowns a New World Record',    'keywords' => 'speed,running'],
            ['title' => 'Console Update Improves Capture Tools',           'keywords' => 'gaming,controller'],
            ['title' => 'Developer Q&A Teases Next Expansion',             'keywords' => 'programmer,code'],
        ];

        foreach ($articles as $index => $article) {
            $title     = $article['title'];
            $keywords  = $article['keywords'];
            $slug      = Str::slug($title);
            $videoType = ['local', 'youtube', 'none'][$index % 3];

            $imagePath = $this->downloadImage($slug, $keywords, $index);

            News::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'             => $title,
                    'short_description' => 'Fresh details, player reactions, and tactical context for one of the biggest gaming stories this week.',
                    'content'           => str_repeat('The gaming scene keeps moving fast, and this update gives players a clear look at what changed, why it matters, and how the community is reacting. Developers highlighted polish, accessibility, and competitive balance while players are already testing new strategies across live servers. ', 3),
                    'category_id'       => $categories[$index % $categories->count()]->id,
                    'author_id'         => $index % 4 === 0 ? $admin->id : $author->id,
                    'image'             => $imagePath,
                    'video_type'        => $videoType,
                    'video_url'         => match ($videoType) {
                        'local'   => $localVideoPath,
                        'youtube' => 'M7lc1UVf-VE',
                        default   => null,
                    },
                    'status'       => $index % 5 === 0 ? 'draft' : 'published',
                    'featured'     => $index < 4,
                    'views'        => random_int(120, 9000),
                    'published_at' => now()->subDays($index),
                ]
            );

            $this->command->info("[$index] {$title}");
        }
    }

    private function downloadImage(string $slug, string $keywords, int $lock): ?string
    {
        $path = 'news/images/' . $slug . '.jpg';

        if (Storage::disk('public')->exists($path)) {
            return $path;
        }

        try {
            $response = Http::withoutVerifying()->timeout(20)->get(
                "https://loremflickr.com/800/450/{$keywords}/all?lock={$lock}"
            );

            if ($response->ok() && str_contains($response->header('Content-Type') ?? '', 'image')) {
                Storage::disk('public')->put($path, $response->body());
                return $path;
            }
        } catch (\Exception $e) {
            // fallback to gradient placeholder in blade
        }

        return null;
    }

    private function localDemoVideo(): string
    {
        return 'TG9jYWwgZ2FtZXBsYXkgZGVtbyB2aWRlbyBwbGFjZWhvbGRlciBmb3Igc2VlZGVkIG5ld3Mu';
    }
}
