<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->paragraphs(5, true)
        ];
    }

    /**
     * Define state of factory to change attr title with default value
     *
     * @return BlogPostFactory
     */
    public function title()
    {
        return $this->state(function (array $attributes) {
           return [
              'title' => 'New Blog Post'
           ] ;
        });
    }
}
