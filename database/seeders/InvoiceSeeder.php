<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   
   
    public function run()
    {
        
         function getName($n =10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
        
            for ($k = 0; $k < $n; $k++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
        
            return $randomString;
        }
           
            
            
        
            //Start point of our date range.
            $start = strtotime("1 January 2020");

            //End point of our date range.
            $end = strtotime("1 July 2021");

            $timestamp = mt_rand($start, $end);

            $date = date("Y-m-d", $timestamp);

            $invoice = new Invoice();
            $invoice->date = $date;
            $invoice->invoice_address = $s;
            $invoice->delivery_address = $s;
            $invoice->invoice_number =  rand(111111,999999);
            $invoice->save();
        
            
            for($j=0; $j<2; $j++)
            {
                $item = new Item();
                $item->description = $s;
                $item->cost = rand(1, 1000);
                $item->qty = rand(1, 20);
                $invoice->item()->save($item);
            }
        
           
    }
}
