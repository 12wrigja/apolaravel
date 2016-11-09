<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(APOSite\Models\Users\User::class, function (Faker\Generator $faker) {
	$semesterIds = [$faker->numberBetween(4000,4034), $faker->numberBetween(4000,4034), $faker->numberBetween(4000, 4034)];
	asort($semesterIds);
	$big = APOSite\Models\Users\User::where('initiation_semester','<', $semesterIds[0])->inRandomOrder()->first();
	$bigId = $big?$big->id:null;   
	return [
	    'id' => $faker->lexify('???').$faker->numberBetween(100,9999),
	    'first_name' => $faker->firstName(),
	    'last_name' => $faker->lastName,
	    'nickname' => $faker->firstName(),
	    'email' => $faker->unique()->safeEmail,
	    'phone_number'=> $faker->phoneNumber,
	    'address' => $faker->streetAddress,
	    'city' => $faker->city,
	    'state' => $faker->state,
	    'zip_code' => $faker->postcode,
	    'campus_residence' => $faker->word,
	    'pledge_semester' => $semesterIds[0],
	    'initiation_semester' => $semesterIds[1],
	    'graduation_semester' => $semesterIds[2],
	    'family_id' => null,
	    'big' => $bigId,
	    'biography' => $faker->paragraph,
	    'join_reason' => $faker->paragraph,
	    'major' => $faker->text(255),
	    'minor' => $faker->text(255),
	    'hometown' => $faker->city.' '.$faker->stateAbbr,
    ];
});

$factory->define(APOSite\Models\Users\Family::class, function(Faker\Generator $faker){
	return [
	 'name'=>$faker->word
	];	
});
