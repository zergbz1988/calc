<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Zergbz1988\Calc\Interfaces\Calc;

Route::get('calc', function (Request $request, Calc $calc) {
    $input = $request->input('input');

    $calcResult = $calc->getCalcResult($input);

    return response()->json([
        'status' => $calcResult->getStatus(),
        'message' => $calcResult->getMessage()
    ]);
});