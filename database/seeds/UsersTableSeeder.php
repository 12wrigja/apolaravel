<?php

use APOSite\Models\Users\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        factory(User::class, 1000)->create();
    }
}
