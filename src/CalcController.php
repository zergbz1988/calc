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
use Illuminate\Support\Facades\Validator;

class CalcController extends Controller
{
    /**
     * @param Request $request
     * @param Calc $calc
     * @return \Illuminate\Http\JsonResponse
     */
    public function calc(Request $request, Calc $calc)
    {
        $validator = Validator::make($request->all(), ['input' => 'required|string']);

        if ($validator->fails()) {
            $calcResult = new CalcResult();
            $calcResult->setErrorStatus();
            $calcResult->setMessage('Необходимо указать строковое значение поля input');

            return response()->json([
                'status' => $calcResult->getStatus(),
                'message' => $calcResult->getMessage()
            ]);
        }

        $input = str_replace(' ', '+', $request->input('input'));
        $calcResult = $calc->getCalcResult($input);

        return response()->json([
            'status' => $calcResult->getStatus(),
            'message' => $calcResult->getMessage()
        ]);
    }
}