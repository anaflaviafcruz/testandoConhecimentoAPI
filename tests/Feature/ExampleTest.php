<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_user_with_success()
    {
        $data = ['name'=>'teste unit','email'=>'email@testunit.com','document'=>'12347678900', 'money' => '100','type' =>'CPF'];

        $response = $this->json('POST', '/api/user/store',$data);
        $response->assertStatus(201);
    }

    public function test_create_user_with_error()
    {
        $data = ['name'=>'teste unit','email'=>'email@testunit.com','document'=>'12347678900', 'money' => '100','type' =>'CPF'];

        $response = $this->json('POST', '/api/user/store',$data);
        $response->assertStatus(422);
    }

    public function test_verification_balance_payer()
    {
        $user = User::find(1);
        
        $this->assertTrue(20 < $user->money);
    }

    public function test_verification_type_payer_cpf()
    {
        $data = ['name'=>'teste unit 2','email'=>'email2@testunit.com','document'=>'12347678911', 'money' => '0','type' =>'CPF'];
        $response = $this->json('POST', '/api/user/store',$data);
        
        $user = User::find(2);

        $this->assertEquals('CPF', $user->type);
    }

    public function test_verification_type_payer_cnpj()
    {
        $data = ['name'=>'teste unit 3','email'=>'email3@testunit.com','document'=>'12347678922', 'money' => '100','type' =>'CNPJ'];
        $response = $this->json('POST', '/api/user/store',$data);
        
        $user = User::find(3);
        
        $this->assertEquals('CNPJ', $user->type);
    }

    public function test_create_transaction()
    {
        $data = ['payer'=> 1 ,'payee'=> 2, 'value' => '20'];

        $response = $this->json('POST', '/api/transaction',$data);
        $response->assertJson(['code' => 201]);
    }
    
}
