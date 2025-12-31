<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
| Route Structure:
| - public.php    : Public routes (guest accessible)
| - auth.php      : Authentication routes (login, register, OAuth)
| - user.php      : User/Customer routes (authenticated users)
| - creator.php   : Creator routes (content creators)
| - admin.php     : Admin routes (administrators)
|
*/

// Load Public Routes
require __DIR__ . '/modules/public.php';

// Load Authentication Routes
require __DIR__ . '/modules/auth.php';

// Load Panel Authentication Routes
require __DIR__ . '/modules/panel-auth.php';

// Load User Routes
require __DIR__ . '/modules/user.php';

// Load Creator Routes
require __DIR__ . '/modules/creator.php';

// Load Panel Routes (Dynamic User Panel)
require __DIR__ . '/modules/panel.php';

// Load Admin Routes
require __DIR__ . '/modules/admin.php';
