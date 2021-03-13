<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;


class ExampleTest extends TestCase
{
    // * because we are creating a fresh DB for every test we have to use this class. To run our migrations for us
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

     //* this test is very basic all it does is makes a get request to home page and makes an assertion that we get a status of 200
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    //* try asserting a JSON or asserting a header next

    // * testing we are returning authenticated user info

    /**@test */
    public function test_user_login()

    {
        $email= env('API_USER_EMAIL');
        $password= env('API_USER_PASSWORD');



        $response =$this->json('POST','/api/login/',[
        'email'=>$email,'password'=>$password]);

        $response ->assertStatus(200);

    }

}



    /* creating new autheticated user via factory
        $this->actingAs(factory(User::class)->create()); */






 // * Example of a test to make sure we redirect user to login if they are trying to access a protected resources

    // * A way to make this test fail is to disable auth middleware

    /*
    public function only_logged_in_users_can_see_the_customers_list(){
        $response = $this->get('/customers')->assertRedirect('/login');
    }

    */
