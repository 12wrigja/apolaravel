<?php

use APOSite\Models\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    use DatabaseMigrations;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => SemesterTableSeeder::class]);

//        App::make(SemesterTableSeeder::class)->run();
//        App::make(GlobalVariablesSeeder::class)->run();
//        App::make(OfficesTableSeeder::class)->run();

        // Setup a Personal Access Token Client
        $this->setUpPersonalAccessAPI();
    }

    public function setUpPersonalAccessAPI()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(null,
            'Test Personal Access Client',
            $this->baseUrl);

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }


    public function buildWebmasterUser()
    {
        $webmaster = $this->buildUser("webmaster", "Web", "Master");

        // Do the thing to make this user a webmaster.

        return $webmaster;
    }

    public function buildUser($id, $first_name, $last_name)
    {
        $user = new User();
        $user->id = $id;
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->save();
        return $user;
    }

    public function buildFakerUser($id, $first_name, $lastName)
    {
        return factory(User::class)->make([
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $lastName,
            'nickname' => '',
        ]);
    }

    public function signInAs($id)
    {
        Auth::once(['id' => $id, 'password' => '']);
        $this->assertTrue(Auth::check());
    }

    // This is used to simulate the requests that users actually do.
    // Eventually this is where we would add in OAuth token headers.
    public function callAPIMethod($method, $uri, $api_key = null, $data = [])
    {
        $this->refreshApplication();
        $this->assertFalse(Auth::check(), 'We are authorized before sending an API method call. This is not correct, and will invalidate th results of the test.');
        $this->json($method, $uri, $data, ['Authorization' => 'Bearer ' . $api_key]);
    }

    public function scopeKey($scopeArray)
    {
        return array_keys($scopeArray)[0];
    }
}
