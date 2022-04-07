<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sumUsers = max((int)$this->command->ask('How many user would you like to added?', 5), 1);

        User::factory()->rootUser()->create();
        User::factory($sumUsers)->create();
    }
}
