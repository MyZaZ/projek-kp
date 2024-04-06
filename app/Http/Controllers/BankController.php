<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the banks.
     */
    public function index()
    {
        $banks = Bank::all();

        return $banks;
    }
}
