<?php

namespace App\Repositories;

use App\Traits\ResponseAPI;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionRepository implements TransactionRepositoryInterface
{
    use ResponseAPI;

    private $usersRepository;

    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
    
    public function create(array $attributes)
    {
        $verificationBalancePayer = $this->verificationBalancePayer($attributes['payer'], $attributes['value']);
        $verificationTypePayer = $this->verificationTypePayer($attributes['payer']);
        if(!$verificationBalancePayer && !$verificationTypePayer){
            $user_payer = $this->user_payer($attributes['payer']);
            $user_payee = $this->user_payee($attributes['payee']);
            return $this->beginTransaction($attributes, $user_payer, $user_payee);
        } else{
            return $this->error([$verificationBalancePayer, $verificationTypePayer], 422);
        } 
    }

    public function beginTransaction($attributes, $user_payer, $user_payee){
        DB::beginTransaction();
        
        try {
            $this->transaction();
            //atualizando valor do pagador
            DB::update('update users set money = ? where id = ?', [$user_payer->money - $attributes['value'], $user_payer->id]);
            
            //atualizando valor do recebedor
            DB::update('update users set money = ? where id = ?', [$user_payee->money + $attributes['value'], $user_payee->id]);
            
            //inserindo transação na tabela
            DB::insert('insert into transactions (payer,payee,value,type) values (?, ?, ?, "CPF")', [$attributes['payer'], $attributes['payee'], $attributes['value']]);

            DB::commit();

            $this->notificationEmail();
            return $this->success("success", null , 201);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function notificationEmail()
    {
        $mock = Http::get('http://o4d9z.mocklab.io/notify');
    
        //Determine if the status code is >= 400 or has a 400 level status code or has a 500 level status code
        if($mock->failed() || $mock->clientError() || $mock->serverError()){
            //colocar na fila para enviar depois
        }
    }

    public function transaction(){
        $mock = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
    
        //Determine if the status code is >= 400 or has a 400 level status code or has a 500 level status code
        if($mock->failed() || $mock->clientError() || $mock->serverError()){
            return response()->json($response->successful(), 400);
        }
        else{
            return true;
        }
    }

    public function verificationBalancePayer($id, $value)
    {
        $user_payer = $this->user_payer($id); 
        
        if($user_payer->money < $value)
            return "Não possui valor em conta";
    }

    public function verificationTypePayer($id)
    {
        $user_payer = $this->user_payer($id); 

        if($user_payer->type == 'CNPJ')
            return  "Ação não autorizada";
    }

    public function user_payer($id)
    {
        $user_payer = $this->usersRepository->findOrFail($id); 
        return $user_payer;  
    }

    public function user_payee($id)
    {
        $user_payee = $this->usersRepository->findOrFail($id); 
        return $user_payee;  
    }

}