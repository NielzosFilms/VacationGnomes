<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'caption' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(0, 100),
            'image' => "https://i.stack.imgur.com/y9DpT.jpg",
        ];
    }
}
