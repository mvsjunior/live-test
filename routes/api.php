<?php

use App\Http\Controllers\Api\CpfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/process-cpf', [CpfController::class,'process']);