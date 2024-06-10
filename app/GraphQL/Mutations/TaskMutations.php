<?php

namespace App\GraphQL\Mutations;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskMutations
{
    public function createTask($root, array $args)
    {
        $checkTask = Task::where('user_id', Auth::id())->where('name', $args['name'])->first();
        
        if ($checkTask) {
            throw new \ErrorException('Task with the same name already exists for this user.');
        }

        $task = Task::create([
            'name' => $args['name'],
            'user_id' => Auth::id(),
            'state' => false
        ]);

        return $task;
    }

    public function updateTask($root, array $args)
    {
        $task = Task::where('user_id', Auth::id())->where('id', $args['id'])->firstOrFail();

        if (isset($args['name']) && $task->name !== $args['name']) {
            $existingTask = Task::where('user_id', Auth::id())->where('name', $args['name'])->first();
            if ($existingTask) {
                throw new \ErrorException('Task with the same name already exists for this user.');
            }
            $task->name = $args['name'];
        }

        if (isset($args['state'])) {
            $task->state = $args['state'];
        }

        $task->save();

        return $task;
    }

    public function deleteTask($root, array $args)
    {
        $task = Task::where('user_id', Auth::id())->where('id', $args['id'])->firstOrFail();
        $task->delete();

        return $task;
    }
}
