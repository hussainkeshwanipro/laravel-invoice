<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function piechart()
    {
        if(Auth::check())
        {
             $inv = Invoice::get()->groupby(function($val){
                    return Carbon::parse($val->date)->format('M');
                });

                $data = array();
                
            foreach($inv as $a=>$value)
            {
                    
                $data[$a] = count($value); 
                 
            }

            return view('chart.piechart', compact('data'));
                
              
                
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }


    public function amountchart()
    {
        if(Auth::check())
        {
            return view('chart.amount');
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }
    
}
