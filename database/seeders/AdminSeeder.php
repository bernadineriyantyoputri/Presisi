<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Administrator',
    'email' => 'adminbapenda@gmail.com',
    'password' => Hash::make('admin123'),
    'role' => 'admin_bapenda'
]);