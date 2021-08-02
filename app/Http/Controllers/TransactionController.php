<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Repositories\TransactionRepository;
use App\Traits\ResponseAPI;  

class TransactionController extends Controller
{
    use ResponseAPI;

    protected $transactions;

    public function __construct(TransactionRepository $transactionsRepository)
    {
        $this->transactions = $transactionsRepository;
    }

    public function store(TransactionStoreRequest $request)
    {    
        return $this->transactions->create($request->all());
    }

}
