<?php

namespace App\Http\Controllers;

use App\Task;

class TaskController extends Controller
{
    public function __invoke()
    {
        return Task::all();
    }
}
