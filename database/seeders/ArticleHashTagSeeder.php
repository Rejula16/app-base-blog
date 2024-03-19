<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\HashTag;

class ArticleHashTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();

        // Loop through each article
        foreach ($articles as $article) {
            // Generate three random hashtags and associate them with the article
            $hashtags = HashTag::inRandomOrder()->limit(3)->get();
            $article->hashtags()->attach($hashtags);
        }
    }
}