<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();

        $user->name = "admin";
        $user->password = "asdf";
        $user->save();

        User::factory()
            ->count(10)
            ->hasPosts(1)
            ->create();
    }
}
