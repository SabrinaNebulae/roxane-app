<?php

namespace Database\Factories;

use App\Models\NotificationTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NotificationTemplate>
 */
class NotificationTemplateFactory extends Factory
{
    protected $model = NotificationTemplate::class;

    public function definition(): array
    {
        return [
            'identifier' => $this->faker->unique()->slug(2),
            'name' => $this->faker->sentence(3),
            'subject' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'variables' => ['name' => 'Nom'],
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
