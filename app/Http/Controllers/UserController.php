<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Repositories\UserRepository;
use App\Traits\ResponseAPI;   

class UserController extends Controller
{
    use ResponseAPI;

    private $usersRepository;

    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        try{
            $user = $this->usersRepository->create($request->all());
            return $this->success("success",$user, 201);
        }catch(\Exception $e){
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
