<?php

namespace App\Controllers;

class UserController
{
    public function index()
    {
        var_dump("Index do users");
    }

    public function show(int $id)
    {
        var_dump("User {$id}");
    }
}
