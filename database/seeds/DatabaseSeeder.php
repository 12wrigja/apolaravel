<?php

use Illuminate\Database\Seeder;
use APOSite\Models\Users\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Core backing data.
        $this->call(SemesterTableSeeder::class);
        $this->call(GlobalVariablesSeeder::class);
        $this->call(OfficesTableSeeder::class);

        // User Base Data.
        $this->call(FamilySeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CarouselItemTableSeeder::class);

        // Build an Admin user.
        $userid = $this->command->ask("What is your case ID, developer?", null);
        if ($userid == null) {
            $this->command->error("You will need a valid Case ID for development. Please try rerunning seeding.");
            return;
        }
        $userFirstName = $this->command->ask("And your first name?", null);
        $userLastName = $this->command->ask("And your last name?". null);
        factory(User::class)->make([
            'id' => $userid,
            'first_name' => $userFirstName,
            'last_name' => $userLastName,
            'nickname' => null,
        ])->save();
        $this->command->info("Creating you in the database!");
    }
}
