<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            $data = Invoice::all();
            return view('invoice.index', compact('data'));
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }

    public function addInvoice()
    {
        if(Auth::check())
        {
            return view('invoice.add');
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }


    public function postInvoice(Request $request)
    {
      

        $request->validate([
            'date' => 'required',
            'invoice_address' => 'required|min:2',
            'delivery_address' => 'required|min:2',
            'invoice_number' => 'required|min:2',
            'desc' => 'required',
            'cost' => 'required',
            'qty' => 'required'
            ]);

        $invoice = new Invoice();
        $invoice->date = $request->date;
        $invoice->invoice_address = $request->invoice_address;
        $invoice->delivery_address = $request->delivery_address;
        $invoice->invoice_number =  $request->invoice_number;
        $invoice->save();
    
        $j = count($request->desc);
        
        for($i=0; $i<$j; $i++)
        {
            $item = new Item();
            $item->description = $request->desc[$i];
            $item->cost = $request->cost[$i];
            $item->qty = $request->qty[$i];
            $invoice->item()->save($item);
        }

        return redirect()->route('invoice')->with('success', 'Data update successful'); 
        
    }

    public function delete($id)
    {
        if(Auth::check())
        {
            $data = Invoice::find($id);
            $data->delete();
            return redirect()->route('invoice')->with('success', 'Invoice deleted successfully');
            
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }

    public function edit($id)
    {
        if(Auth::check())
        {
            $data = Invoice::find($id);
            return view('invoice.update', compact('data'));
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }


    public function update(Request $request)
    {
        if(Auth::check())
        {
            $data = $request->all();
            $invoice = Invoice::find($request->invoice_id);
            $invoice->date = $data['date'];
            $invoice->invoice_address = $data['invoice_address'];
            $invoice->delivery_address = $data['delivery_address'];
            $invoice->invoice_number = $data['invoice_number'];

           
            if($request->has('desc'))
            {
                $b = count($request->desc);
        
                for($a=0; $a<$b; $a++)
                {
                    $item = Item::find($request->item_id);
                    $item->description = $request->desc[$a];
                    $item->cost = $request->cost[$a];
                    $item->qty = $request->qty[$a];
                    $invoice->item()->save($item);
                }
            }

            if($request->has('ndesc'))
            {
                $j = count($request->ndesc);
        
                for($i=0; $i<$j; $i++)
                {
                    $item = new Item();
                    $item->description = $request->ndesc[$i];
                    $item->cost = $request->ncost[$i];
                    $item->qty = $request->nqty[$i];
                    $invoice->item()->save($item);
                }
            }

            if($request->has('delete'))
            {
                foreach($request->delete as $del)
                {
                  $itemDel = Item::find($del);
                  $itemDel->delete();
                }
            }


            $invoice->save();
            
            return redirect()->route('invoice')->with('success', 'Invoice updated successfully');
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }

    }

    public function pdf($id)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $invoice = Invoice::find($id);
            $total = 0;
            foreach($invoice->item as $a)
            {
                $b = ($a->qty*$a->cost);
                $total += $b;
            }
            $gst = ($total*18)/100;
            $grandTotal = $total+$gst;
 
            $mpdf = new \Mpdf\Mpdf();
          
        
            
            
        $html  = 
        '
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">


            
        </head>

        <body>
            <div class="container">
                <div class="brand-section">
                    <div class="row">

                        <div class="col-4 ">
                            <h1 class="text-white">INVOICE</h1>
                        </div>
                        <div class="col-4">
                            <div class="company-details">
                                <p class="text-white">'.$invoice->invoice_address.'</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="company-details">
                                <p class="text-white">647-444-1234</p>
                                <p class="text-white">your@email.com</p>
                                <p class="text-white">Yourwebsite.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="body-section">
                    <div class="row">
                        <div class="col-4">

                            <p class="heading">Billed To</p>
                            <p class="sub-heading">'.$invoice->delivery_address.'</p>


                        </div>
                        <div class="col-4">
                            <div class="company-details">
                                <p class="heading">Invoice Number</p>
                                <p class="sub-heading">'.$invoice->invoice_number.'</p>
                                <p class="heading">Date of issue</p>
                                <p class="sub-heading">'.date_format($invoice->created_at, "D M Y").'</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="company-details">
                                <p class="he">Invoice Total</p>
                                <h1 class="w-2">Rs. '.$grandTotal.'</h1>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="body-section">
                    <table>

                        <tr align="right">
                            <th class="w-20">
                                Description
                            </th>
                            <th class="w-20">Cost</th>
                            <th class="w-20">Quantity</th>
                            <th class="w-20">Amount</th>

                        </tr>';
                       
                    foreach($invoice->item as $item){
                        $html .= '
                        <tr>
                            <td>'.$item->description.'</td>
                            <td>'.$item->cost.'</td>
                            <td>'.$item->qty.'</td>
                            <td>'.$item->qty*$item->cost.'</td>
                        </tr>
                        '; 
                    }
                    $html .= '<tr>
                            <td colspan="3" class="text-right">Sub Total</td>
                            <td>Rs. '.$total.'</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">Tax (18% GST)</td>
                            <td>Rs. '.$gst.'</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">Total</td>
                            <td>Rs. '.$grandTotal.'</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">Amount Due</td>
                            <td>Rs. '.$grandTotal.'</td>
                        </tr>

                    </table>
                    <br>
                    <p class="heading"> Invoice Terms</p>
                    <h4 class="sub-heading">Ex.Please pay your invoice by....</h4>
                </div>

            </div>

            
        </body>

        </html>
       ';

        $stylesheet = file_get_contents('public/style.css');
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
       

            $mpdf->Output();
        }
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }

    
    public function piechart()
    {
        if(Auth::check())
        {
            return $inv = Invoice::leftJoin('invoices', 'items', 'items.invoice_id')
                            ->get()
                            ->groupby(function($val){
                                return Carbon::parse($val->date)->format('M');
               
                         });
          
        }   
        else
        {
            return redirect()->route('login')->with('error', 'Session Timeout Login Again');
        }
    }
}

