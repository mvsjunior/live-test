<?php

namespace App\Http\Controllers\Api;

use App\Actions\ProcessCpfAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CpfController extends Controller
{
    public function process(Request $request, ProcessCpfAction $processCpfAction ){

        $cpf = $request->cpf;


        $cpfProcessed = $processCpfAction->handle($cpf);
        
        return response()->json($cpfProcessed);
    }
}
