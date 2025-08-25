<?php
/**
 * Archivo de rutas principal del sistema Cashflow.
 * Define las rutas web y API, asociando cada endpoint con su controlador y acción.
 * @package routes
 */
use App\Controllers\HomeController;
use App\Controllers\Api\MovementController;
use App\Controllers\Api\ReportController;
use App\Controllers\ProjectController;
use App\Controllers\BankAccountController;
use App\Controllers\MovementController as WebMovementController;
use App\Controllers\AdjustmentController;
use App\Controllers\CostCenterController;
use App\Controllers\AuditLogController;
use App\Controllers\UserController;

/* Web */
$router->get('/', [HomeController::class, 'index']);
$router->get('/projects', [ProjectController::class, 'index']);
$router->get('/projects/create', [ProjectController::class, 'create']);
$router->post('/projects', [ProjectController::class, 'store']);
$router->get('/bank-accounts', [BankAccountController::class, 'index']);
$router->get('/bank-accounts/create', [BankAccountController::class, 'create']);
$router->post('/bank-accounts', [BankAccountController::class, 'store']);
$router->get('/movements', [WebMovementController::class, 'index']);
$router->get('/movements/create', [WebMovementController::class, 'create']);
$router->post('/movements', [WebMovementController::class, 'store']);
$router->get('/prioritization', [HomeController::class, 'prioritization']);
$router->get('/reports/project-balance', [HomeController::class, 'projectBalance']);
$router->get('/adjustments', [AdjustmentController::class, 'index']);
$router->post('/adjustments', [AdjustmentController::class, 'store']);
$router->get('/cost-centers', [CostCenterController::class, 'index']);
$router->get('/cost-centers/create', [CostCenterController::class, 'create']);
$router->post('/cost-centers', [CostCenterController::class, 'store']);
$router->get('/audit-logs', [AuditLogController::class, 'index']);
$router->get('/users', [UserController::class, 'index']);
$router->get('/users/create', [UserController::class, 'create']);
$router->post('/users', [UserController::class, 'store']);

/* API */
$router->get('/api/movements', [MovementController::class, 'list']);
$router->post('/api/movements', [MovementController::class, 'create']);
$router->get('/api/reports/project-balance', [ReportController::class, 'projectBalance']);
// Import removed


