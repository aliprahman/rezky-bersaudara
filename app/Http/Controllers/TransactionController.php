<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $trx = Transaction::create([
            'type' => 1,
            'transaction_date' => date('Y-m-d H:i:s'),
            'product_id' => 1,
            'price' => 10000,
            'quantity' => 2,
            'total' => 20000,
            'notes' => 'test',
            'user_id' => 1
        ]);

        return $trx;
    }
}
