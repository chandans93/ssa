<?php
namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\Auction;
use DB;
use Datatables;
use File;
use Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuctionRequest;
use App\Services\Auction\Contracts\AuctionRepository;
use App\Services\Product\Contracts\ProductRepository;


class AuctionController extends Controller {

	public function __construct(AuctionRepository $AuctionRepository,ProductRepository $ProductRepository) {
       
       $this->AuctionRepository = $AuctionRepository;
       $this->ProductRepository = $ProductRepository; 
       $this->objAuction = new Auction();
       $this->controller = 'AuctionController';
    }
	 
    public function index() {
        $auctiondetail = [];
        return view('admin.addauction', compact('auctiondetail'));
    }
    public function save(AuctionRequest $AuctionRequest){
    	
    	$auctiondetail = [];

    	$originalstartDate = e(input::get('a_starttime'));
		$startdate = date("Y-m-d H:i:s", strtotime($originalstartDate));

		$originalendDate = e(input::get('a_endtime'));
		$enddate = date("Y-m-d H:i:s", strtotime($originalendDate));

    	$auctiondetail['id']             = e(input::get('id')); ;
    	$auctiondetail['au_winner_id']   = 0;
        $auctiondetail['au_product_id']  = e(input::get('a_product')); 
        $auctiondetail['au_start_time']  = $startdate;
        $auctiondetail['au_status']      = e(input::get('a_status'));
        $auctiondetail['au_bid_type']    = e(input::get('a_bidtype'));
        $auctiondetail['au_fees']        = e(input::get('a_fees'));
        $auctiondetail['au_bid_voucher'] = e(input::get('a_bidvoucher'));
        $auctiondetail['au_end_time']    = $enddate;
        
        $auctiondetail['updated_at']     = date('Y-m-d H:i:s');

        if(!isset($auctiondetail['id'])){
            $auctiondetail['created_at']  = date('Y-m-d H:i:s');
        }else{ 
            if($auctiondetail['au_bid_type'] == 1 ){
                $auctiondetail['au_fees']    =  0;
            }

        }
         
        $response = $this->AuctionRepository->saveDetail($auctiondetail); 
         
        if ($response) {
            if($response == 1)
            {
                return Redirect::to("admin/auction")->with('success', trans('adminlabels.formlblauctionsuccess'));
            }
            elseif ($response == 2) {
                return Redirect::to("admin/auction")->with('success', trans('adminlabels.auctionupdatesuccess'));
            }
        } else {
            return Redirect::to("admin/auction")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }

    }
    public function auctionlist() {
        return view('admin.ListAuction')->with('controller', $this->controller);
    }

    //get auctionlist
    public function getauction() {

        $data = $this->AuctionRepository->getDetail();

        foreach ($data as $key => $val) {
            if (isset($val['au_product_id']) && $val['au_product_id'] > '0') {

                //get productname from product id 
                $au_product_id = $val['au_product_id'];
                $val['au_product_id'] = $au_product_id = $this->ProductRepository->getproductname($au_product_id);

                //get status name from helper
                $status = Helpers::getAuctionstatus();
                foreach ($status as $key => $value){
                    if($val['au_status'] == $key){
                        $val['au_status'] = $statusname = $value;
                    }
                }

                //get bidtype from helper
                $autype = Helpers::getBidtype();
                foreach ($autype as $key => $bvalue){
                    if($val['au_bid_type'] == $key){
                        $val['au_bid_type'] = $sbidtype = $bvalue;
                    }
                }

            }
        }
         
        return Datatables::of($data)
                        ->editColumn('au_product_id', '@if ($au_product_id == 0) <span style="text-align: center;display: block; padding-right:50%;">{{$au_product_id}}</span>
                         @else <span style="text-align: center;display: block;  padding-right:50%;">-</span> @endif')
                        ->editColumn('au_status', '@if ($au_status == 0) <span style="text-align: center;display: block; padding-right:50%;">{{$au_status}}</span>
                         @else <span style="text-align: center;display: block;  padding-right:50%;">-</span> @endif')
                        ->editColumn('au_bid_type', '@if ($au_bid_type == 0) <span style="text-align: center;display: block; padding-right:50%;">{{$au_bid_type}}</span>
                         @else <span style="text-align: center;display: block;  padding-right:50%;">-</span> @endif')
                        ->add_column('actions', '<a href="{{ route(".data.editauction", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                             <a  href="{{ route(".data.deleteauction", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        ->make(true);
    }
    public function edit($id){
        $auctiondetail = $this->objAuction->find($id);
        return view('admin.addauction', compact('auctiondetail'));
    }
    public function delete($id){
        $return = $this->AuctionRepository->deleteAuction($id);
        if ($return) {
            return Redirect::to("admin/auction")->with('success', trans('adminlabels.auctiondeletesuccess'));
        } else {
            return Redirect::to("admin/auction")->with('error', trans('adminlabels.commonerrormessage'));
        }
    }
    
    
    public function request() {

        return view('admin.ListRequestAuction')->with('controller', $this->controller);
    }
    public function getRequestAuction() {
        
        
        
        $request_details = DB::select("SELECT vpp.p_title as product_name,vpp.id ,COUNT(vaar.id) as request_auction FROM vw_p_product as vpp INNER JOIN vw_ar_auction_request as vaar ON vpp.id = vaar.ar_product_id where vaar.deleted !=3 GROUP BY vaar.ar_product_id ");
        $data= collect($request_details);
       
        return Datatables::of($data)
                       ->add_column('actions', '<a  href="{{ route(".data.deleterequest", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"> <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
                        
                        ->make(true);
    }
    
    public function deleterequete($id) {
        $return = $this->AuctionRepository->deleteAuctionRequest($id);
        if ($return) {

            return Redirect::to("admin/request")->with('success', trans('adminlabels.auctionrequestdelete'))->with('controller', $this->controller);
        } else {

            return Redirect::to("admin/request")->with('error', trans('adminlabels.commonerrormessage'))->with('controller', $this->controller);
        }
    }

}
