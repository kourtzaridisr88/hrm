<?php

use Hr\Interfaces\API\Controllers\ReportsController;
use Hr\Interfaces\API\Controllers\DepartmentsController;
use Hr\Interfaces\API\Controllers\EmployeesController;
use Hr\Interfaces\API\Controllers\UsersController;
use Hr\Interfaces\API\Controllers\LoginController;

$router->post('/users', [UsersController::class, 'store']);
$router->post('/auth/login', [LoginController::class, 'store']);
$router->post('/auth/logout', [LoginController::class, 'logout']);
$router->get('/reports', [ReportsController::class, 'index']);

// Departments REST Endpoints
$router->get('/departments', [DepartmentsController::class, 'index']);
$router->post('/departments', [DepartmentsController::class, 'store']);
$router->get('/departments/{id}', [DepartmentsController::class, 'show']);
$router->put('/departments/{id}', [DepartmentsController::class, 'update']);
$router->delete('/departments/{id}', [DepartmentsController::class, 'destroy']);

// Employees REST Endpoints
$router->get('/employees', [EmployeesController::class, 'index']);
$router->post('/employees', [EmployeesController::class, 'store']);
$router->get('/employees/{id}', [EmployeesController::class, 'show']);
$router->put('/employees/{id}', [EmployeesController::class, 'update']);
$router->delete('/employees/{id}', [EmployeesController::class, 'destroy']);