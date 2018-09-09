<?php
/**
 * Created by PhpStorm.
 * User: Marat
 * Date: 06.09.2018
 * Time: 23:15
 */

namespace Zergbz1988\Calc;

use Illuminate\Routing\Controller;
use Zergbz1988\Calc\Interfaces\Calc;
use Illuminate\Http\Request;


class CalcController extends Controller
{
    /**
     * @param Request $request
     * @param Calc $calc
     * @return \Illuminate\Http\JsonResponse
     */
    public function calc(Request $request, Calc $calc)
    {
        $input = str_replace(' ', '+', $request->input('input'));
        $calcResult = $calc->getCalcResult($input);

        return response()->json(
            $calcResult->toArray()
        );
    }
}