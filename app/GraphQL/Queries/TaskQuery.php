<?php

namespace App\GraphQL\Queries;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskQuery
{
    public function tasks()
    {
        return Task::where('user_id', Auth::id())->get();
    }
}
