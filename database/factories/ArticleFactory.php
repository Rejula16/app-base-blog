<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Article,User,Category,HashTag};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{

    protected $model = Article::class;

    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
    // {

        
    //     return [
    //         'user_id'=>function () {
    //             return \App\Models\User::factory()->create()->id;
    //         },
    //         'title' => $this->faker->sentence,
    //         'body' => $this->faker->paragraph,
    //         'category_id' => function () {
    //             return \App\Models\Category::factory()->create()->id;
    //         },
    //     ];
    // }


    // protected $model = Article::class;

    public function definition(): array
    {

        $user = User::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();

        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'user_id'=> $user->id,
            'category_id'=>$category->id,
            
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Article $article) {

            // Retrieve a random user and category from the database
            // $user = User::inRandomOrder()->first();
            // $category = Category::inRandomOrder()->first();

            // Attach the user and category to the article
            // $article->user_id = $user->id;
            // $article->category_id = $category->id;
            // $article->save();

            // Retrieve random hash tags from the hash_tags table
            $randomLimit = rand(1, 4);
            $hashTags = HashTag::inRandomOrder()->limit($randomLimit )->pluck('id')->toArray();

            // Sync the retrieved hash tags with the article
            $article->hashTags()->sync($hashTags);
        });
    }

}