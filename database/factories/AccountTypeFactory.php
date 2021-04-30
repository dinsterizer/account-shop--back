<?php

namespace Database\Factories;

use App\Models\AccountFee;
use App\Models\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /**
         * Properties must define
         * 'game_id'
         */
        return [
            'name' => $this->faker->name,
            'slug' => fn ($attrs) => Str::slug($attrs['name']),
            'description' => $this->faker->title,
        ];
    }

    /**
     * a28s = autoCreateSmallerRelationships
     *
     */
    public function a28s()
    {
        return $this->has(
            AccountFee::factory()
                ->count(rand(1, 4))
                ->a28s(),
            'accountFees'
        );
    }
}