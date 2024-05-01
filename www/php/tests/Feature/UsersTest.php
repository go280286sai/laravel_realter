<?php

namespace Tests\Feature;


use App\Http\Controllers\User\UserController;
use App\Mail\User_email;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/user/users', [
                '_token' => csrf_token(),
                'name' => 'test',
                'birthday' => '2000-01-01',
                'gender_id' => 1,
                'email' => 'test@email.com',
                'password' => 'test1234',
                'phone' => '0950000000',
                'description' => 'test',
            ]);
        $response = User::where('name', 'test')->first();
        $this->assertTrue($response->name == 'test');
        $this->assertTrue($response->gender_id == 1);
        $this->assertTrue($response->birthday == '2000-01-01');
        $this->assertTrue($response->email == 'test@email.com');
        $this->assertTrue($response->phone == '0950000000');
        $this->assertTrue($response->description == 'test');
    }

    public function test_index()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/user/users');
        $response->assertSee($user->name);
        $this->assertTrue($response->status() == 200);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/user/users', [
                '_token' => csrf_token(),
                'name' => 'test',
                'birthday' => '2000-01-01',
                'gender_id' => 1,
                'email' => 'test@email.com',
                'password' => 'test1234',
                'phone' => '0950000000',
                'description' => 'test',
            ]);
        $response = User::where('name', 'test')->first();
        $this->assertTrue($response->name == 'test');
        $this->assertTrue($response->gender_id == 1);
        $this->assertTrue($response->birthday == '2000-01-01');
        $this->assertTrue($response->email == 'test@email.com');
        $this->assertTrue($response->phone == '0950000000');
        $this->assertTrue($response->description == 'test');
        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->put('/user/users/' . $response->id, [
                '_token' => csrf_token(),
                'name' => 'test2',
                'birthday' => '2002-02-02',
                'gender_id' => 2,
                'password' => 'test1234',
                'phone' => '0950000002',
                'description' => 'test2',
            ]);
        $response = User::where('name', 'test2')->first();
        $this->assertTrue($response->name == 'test2');
        $this->assertTrue($response->gender_id == 2);
        $this->assertTrue($response->birthday == '2002-02-02');
        $this->assertTrue($response->phone == '0950000002');
        $this->assertTrue($response->description == 'test2');
    }

    public function test_remove()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/user/users', [
                '_token' => csrf_token(),
                'name' => 'test',
                'birthday' => '2000-01-01',
                'gender_id' => 1,
                'email' => 'test@email.com',
                'password' => 'test1234',
                'phone' => '0950000000',
                'description' => 'test',
            ]);
        $response = User::where('name', 'test')->first();
        $this->assertTrue($response->name == 'test');
        $this->assertTrue($response->gender_id == 1);
        $this->assertTrue($response->birthday == '2000-01-01');
        $this->assertTrue($response->email == 'test@email.com');
        $this->assertTrue($response->phone == '0950000000');
        $this->assertTrue($response->description == 'test');
        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/user/users/' . $response->id, [
                '_token' => csrf_token(),
            ]);
        $response = User::where('name', 'test')->first();
        $this->assertTrue($response == null);
    }

    public function test_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/user/users', [
                '_token' => csrf_token(),
                'name' => 'test',
                'birthday' => '2000-01-01',
                'gender_id' => 1,
                'email' => 'test@email.com',
                'password' => 'test1234',
                'phone' => '0950000000',
                'description' => 'test',
            ]);
        $response = User::where('name', 'test')->first();
        $this->assertTrue($response->name == 'test');
        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/user/add_comment_user', [
                '_token' => csrf_token(),
                'id' => $response->id,
                'comment' => 'new test',
            ]);
        $response = User::where('name', 'test')->first();

        $this->assertTrue($response->comment == 'new test');
    }

    public function test_email()
    {
        Mail::fake();
        Auth::shouldReceive('user')->andReturn((object)['email' => 'user@example.com', 'name' => 'John Doe']);
        Log::shouldReceive('info');

        $request = Request::create('/send-message', 'POST', [
            'content' => 'This is a test message.',
            'title' => 'Test Title',
            'email' => 'receiver@example.com',
        ]);

        $controller = new UserController();

        // Действие
        $response = $controller->sendMessage($request);

        // Проверка
        Mail::assertSent(User_email::class, function ($mail) use ($request) {
            return $mail->hasTo('receiver@example.com') &&
                $mail->cc[0]['address'] === 'user@example.com';
        });

        // Проверяем редирект
        $this->assertEquals(url('/user/users'), $response->getTargetUrl());

    }
}
