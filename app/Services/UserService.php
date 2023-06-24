<?php

namespace App\Services;

use App\Exceptions\CustomQueryException;
use App\Exceptions\CustomValidationException;
use App\Http\Controllers\API\AuthApiController;
use App\Repositories\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomValidationException
     * @throws CustomQueryException
     */
    public function register($data): mixed
    {
        $password = $data['password'];
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);

        //Generate token
        $tokens = $this->generateToken($user->email, $password);
        $user['access_token'] = $tokens->access_token;
        $user['refresh_token'] = $tokens->refresh_token;
        return $user;
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomValidationException
     * @throws CustomQueryException|AuthenticationException
     */
    public function login($data): mixed
    {
        $password = $data['password'];
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            $user = $this->userRepository->findOneBy(['email' => $data['email']]);
            //Generate token
            $tokens = $this->generateToken($user->email, $password);
            $user['access_token'] = $tokens->access_token;
            $user['refresh_token'] = $tokens->refresh_token;
            return $user;
        }
        else{
            throw new AuthenticationException('Unauthenticated credentials');
        }
    }

    /**
     * @return mixed
     * @throws CustomQueryException
     */
    public function list(): mixed
    {
        return $this->userRepository->findAll([]);
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomQueryException
     */
    public function store($data): mixed
    {
        return $this->userRepository->create($data);
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomQueryException
     */
    public function getOneBy($data): mixed
    {
        return $this->userRepository->findOneBy($data);
    }

    /**
     * @param $data
     * @return mixed
     * @throws CustomQueryException
     */
    public function update($data): mixed
    {
        return $this->userRepository->update($this->userRepository->findOneBy(['id'=> $data['id']]), $data);
    }

    /**
     * @param $id
     * @return mixed
     * @throws CustomQueryException
     */
    public function delete($id): mixed
    {
        return $this->userRepository->delete($id);
    }

    /**
     * @param $phoneNumber
     * @param $password
     * @return mixed
     * @throws CustomValidationException
     */
    private function generateToken($email, $password): mixed
    {
        request()->request->add([
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_GRANT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_GRANT_PASSWORD_CLIENT_SECRET'),
            'username' => $email,
            'password' => $password,
            'scope' => '*',
        ]);
        $tokenRequest = request()->create('oauth/token', 'POST', request()->all());
        $tokens = json_decode(Route::dispatch($tokenRequest)->getContent());
        if (!isset($tokens->access_token)) {
            throw new CustomValidationException('Unauthenticated Client credentials');
        }
        return $tokens;
    }
}
