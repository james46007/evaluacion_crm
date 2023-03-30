<?php

namespace App\Http\Controllers;

use App\Models\Results;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function index(){
        return view('array/index');
    }

    public function verify(Request $request) {
        $n = $request->input('n');
        $k = $request->input('k');
        $arr = $request->input('array');;
        $count = 0;
        rsort($arr);
        for ($i=0; $i < count($arr)-1; $i ++) {
            for ($j=$i+1; $j < count($arr); $j ++) {
                if (($arr[$i] - $arr[$j]) == $k) {
                    $count++;
                }
            }
        }

        $resultSave = new Results();

        $resultSave->n = $n;
        $resultSave->k = $k;
        $resultSave->result = $count;
        $resultSave->array = json_encode($arr);
        $resultSave->save();

        return Results::orderBy("created_at", 'desc')->select('n','k','result','array')->get();
    }

    public function list(Request $request) {
        return Results::orderBy("created_at", 'desc')->select('n','k','result','array')->get();
    }
}
