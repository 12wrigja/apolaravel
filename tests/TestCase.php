<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use APOSite\Models\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use APOSite\Models\Office;
use APOSite\Models\Semester;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'SemesterTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'GlobalVariablesSeeder']);

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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }


    public function buildFakerUserInOffices($id, ...$officeIds)
    {
        $officeHolder = $this->buildFakerUser($id, "Office", "Holder");
        $officeHolder->save();

        // Do the thing to make this user be in those office ID's.
        foreach ($officeIds as $oId) {
            $office = Office::find($oId);
            if($office == null) {
                $office = factory(Office::class)->make([
                    'id'=>$oId
                ]);
                $office->save();
            }
            $office->users()->sync([$officeHolder->id => ['semester_id' => Semester::currentSemester()->id]]);
        }

        return $officeHolder;
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

    /** This is used to simulate the API requests that users actually do.
     * @param $method string method for the call, such as GET, POST, PUT, PATCH, DELETE, etc
     * @param $uri string The URI to use. This should probably be a fully specified URL, such as /api/v1/users
     * @param string|null $api_key The API OAuth2 Access Token to use when making this request.
     * @param array $data The data to send in the body of the request, transformed into JSON.
     *
     * @return TestResponse The response from the method call.
     */
    public function callAPIMethod($method, $uri, $api_key = null, $data = [])
    {
        $this->refreshApplication();
        $this->assertFalse(Auth::check(), 'We are authorized before sending an API method call. This is not correct, and will invalidate th results of the test.');
        return $this->json($method, $uri, $data, ['Authorization' => 'Bearer ' . $api_key]);
    }

    /** Converts a Scope (defined on a controller, such as the UserAPIController) into it's key used to identify it.
     * @param $scopeArray array The scope object. For example, UserAPIController::$SCOPE_VIEW_PROFILE
     * @return string The ID of the scope.
     */
    public function scopeKey($scopeArray)
    {
        return array_keys($scopeArray)[0];
    }
}
