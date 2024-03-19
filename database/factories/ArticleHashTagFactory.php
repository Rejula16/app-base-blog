<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ArticleHashTag;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleHashTagFactory extends Factory
{

    protected $model = ArticleHashTag::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'article_id' => function () {
                    return \App\Models\Article::factory();
                },
            'hashtag_id' => function () {
                return \App\Models\HashTag::factory();
            },
           
        ];
    }
}