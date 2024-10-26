<?php
namespace App\Services\User;

interface AuthServiceInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout($user);
}
