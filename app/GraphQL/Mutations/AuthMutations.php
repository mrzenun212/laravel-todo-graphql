<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AuthMutations
{
    public function login($rootValue, array $args, GraphQLContext $context)
    {
        $credentials = ['email' => $args['email'], 'password' => $args['password']];

        if (!Auth::attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['token' => $token, 'user' => $user];
    }

    public function logout($rootValue, array $args, GraphQLContext $context)
    {
        $user = $context->user();
        $user->currentAccessToken()->delete();

        return ['message' => 'Logged out'];
    }
}