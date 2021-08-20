<?php 
namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Payment;
use App\Vouchers;
use Redirect;
use App\Transactions;
use App\Coins;
use App\Services\PurchaseCoins\Contracts\PurchaseCoinsRepository;
use App\Services\PurchaseVoucher\Contracts\PurchaseVoucherRepository;

class PaymentController extends Controller {
    
    public function __construct(PurchaseCoinsRepository $PurchaseCoinsRepository, PurchaseVoucherRepository $PurchaseVoucherRepository)
    {       
        $this->objVouchers = new Vouchers();
        $this->objTransactions = new Transactions();
        $this->objCoins = new Coins();
        $this->PurchaseVoucherRepository = $PurchaseVoucherRepository;
        $this->PurchaseCoinRepository = $PurchaseCoinsRepository;
    }
    
    public function payment($id, $type){
        if($type == "voucher")
        {
            $buyProductDetails = $this->objVouchers->find($id);  
        }
        else if($type == "coin")
        {
            $buyProductDetails = $this->objCoins->find($id);
        }
        else{
           $buyProductDetails = []; 
        }
      return view('front.Payment', compact('buyProductDetails', 'type'));
    }
    
    public function paymentInfo(){ 
        if($_REQUEST['payment_status'] == "Completed")
        {
        $this->objTransactions->t_txn_id = $_REQUEST['txn_id'];
        $this->objTransactions->t_currency = $_REQUEST['mc_currency'];
        $this->objTransactions->t_payment_date = date('Y-m-d', strtotime($_REQUEST['payment_date']));
        $this->objTransactions->t_payment_gross = $_REQUEST['payment_gross'];
        $this->objTransactions->t_payment_status = $_REQUEST['payment_status'];
        $this->objTransactions->t_user_id = $_REQUEST['custom'];
        $this->objTransactions->t_purchased_item = $_REQUEST['item_name'];
        $this->objTransactions->t_purchased_item_id = $_REQUEST['item_number'];
        $savedData = $this->objTransactions->save();
        //$totalItems = '';
        if($_REQUEST['item_name'] == 1)
        {
            $vouchers = $this->objVouchers->find($_REQUEST['item_number']);
            $purchaseDetail['pv_user_id'] = $_REQUEST['custom'];
            $purchaseDetail['pv_total_voucher'] = $vouchers->v_pack;
            $purchaseDetail['pv_total_spent'] = $_REQUEST['payment_gross'];
            $purchaseDetailSaved = $this->PurchaseVoucherRepository->savePurchaseVoucharDetail($purchaseDetail);
        }
        else if($_REQUEST['item_name'] == 2)
        {
            $coins = $this->objCoins->find($_REQUEST['item_number']);
            $purchaseDetail['pc_user_id'] = $_REQUEST['custom'];
            $purchaseDetail['pc_total_coins'] = $coins->c_coins;
            $purchaseDetail['pc_purchased_date'] = $_REQUEST['payment_date'];
            $purchaseDetail['pc_total_price'] = $_REQUEST['payment_gross'];
            $purchaseDetailSaved = $this->PurchaseCoinRepository->savePurchaseCoinDetail($purchaseDetail);
        }
       
        if(isset($purchaseDetailSaved) && isset($savedData))
        {
             return Redirect::to('/')->with('success', 'Payment Successfully Completed');
        }
        else
        {
            return Redirect::to('/')->with('error', 'Payment has been Failed');
        }
        }
        else{
            return Redirect::to('/')->with('error', 'Payment has been Failed');
        }
    }
    
    public function cancelTransaction(){
         return Redirect::to('/')->with('error', 'Payment does not Completed');
    }
    
    
}
 ?>