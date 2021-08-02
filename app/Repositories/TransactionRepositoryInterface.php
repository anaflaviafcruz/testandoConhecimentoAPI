<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

interface TransactionRepositoryInterface
{

    public function beginTransaction($attributes, $user_payer, $user_payee);
    
    public function notificationEmail();
    
    public function transaction();

    public function verificationBalancePayer($id, $value);

}