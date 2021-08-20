<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use Datatables;
use DB;
use App\Coins;
use App\Transactions;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Services\Transaction\Contracts\TransactionsRepository;

class TransactionsController extends Controller
{
    public function __construct(TransactionsRepository $TransactionsRepository)
    {
        $this->middleware('auth.admin');
        $this->controller = 'TransactionsController';
        $this->loggedInUser = Auth::admin()->get();
    }

    public function index()
    {
        
       return view('admin.ListTransaction')->with('controller',$this->controller);
    }
    
    public function  getdata()
    {    
       
          
        $data = DB::table("vw_t_transactions AS transaction ")
                ->leftjoin("vw_fu_front_users AS user ", 'transaction.t_user_id', '=', 'user.id')
                ->selectRaw('transaction.*,user.fu_first_name,user.fu_last_name')
                ->whereRaw('transaction.deleted IN (1,2)');
        


        return Datatables::of($data)
                ->edit_column('t_currency', '{{$t_payment_gross}} {{$t_currency}}')
                ->edit_column('t_user_id', '{{$fu_first_name}} {{$fu_last_name}}')
                ->edit_column('t_purchased_item', '<?php if($t_purchased_item == 1){ echo "Voucher"; } else if($t_purchased_item == 2) { echo "Coin"; } ?>')
                 ->make(true);
                  
    }
}