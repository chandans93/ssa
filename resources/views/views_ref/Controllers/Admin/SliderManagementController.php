<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use Config;
use Helpers;
use Redirect;
use App\Slider;
use DB;
use Datatables;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Services\Slider\Contracts\SliderRepository;
use Image;

class SliderManagementController extends Controller {
    

    public function __construct(SliderRepository $SliderRepository)
    {       
        $this->middleware('auth.admin');
        $this->slider = new slider();
        $this->SliderRepository = $SliderRepository;
        $this->controller = 'SliderManagementController';
        $this->loggedInUser = Auth::admin()->get();
        $this->sliderOriginalImageUploadPath = Config::get('constant.SLIDER_ORIGINAL_IMAGE_UPLOAD_PATH');
        $this->sliderThumbImageUploadPath = Config::get('constant.SLIDER_THUMB_UPLOAD_PATH');
        $this->sliderBigImageUploadPath = Config::get('constant.SLIDER_BIG_UPLOAD_PATH');
        $this->sliderAdminImageHeight = Config::get('constant.SLIDER_ADMIN_IMAGE_HEIGHT');
        $this->sliderAdminImageWidth= Config::get('constant.SLIDER_ADMIN_IMAGE_WIDTH');
        $this->sliderBigImageHeight = Config::get('constant.SLIDER_HOME_IMAGE_HEIGHT');
        $this->sliderBigImageWidth = Config::get('constant.SLIDER_HOME_IMAGE_WIDTH');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ListSlider')->with('controller',$this->controller);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $sliderDetail = [];
        return view('admin.EditSlider', compact('sliderDetail'))->with('controller',$this->controller);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(SliderRequest $SliderRequest)
    {
        $sliderDetail = [];
        $sliderDetail['id'] = e(input::get('id'));
        $sliderDetail['hps_redirection_link'] = e(input::get('hps_redirection_link'));
        $sliderDetail['hps_display_status'] = e(input::get('hps_display_status'));
         $sliderDetail['deleted'] = e(input::get('deleted'));

        if (Input::file())
        {
            $file = Input::file('hps_image');
            if(!empty($file))
            {

                if (isset( $sliderDetail['id'])&&$sliderDetail['id']>0){
                    $sliderImage = $this->slider->find($sliderDetail['id']);
                    if(isset($sliderImage->hps_image) && $sliderImage->hps_image!=''){
                         unlink($this->sliderOriginalImageUploadPath.$sliderImage->hps_image);
                         unlink($this->sliderThumbImageUploadPath.$sliderImage->hps_image);
                         unlink($this->sliderBigImageUploadPath.$sliderImage->hps_image);
                     }
                }
                
                $fileName = 'slider_' . time() . '.' . $file->getClientOriginalExtension();
                $pathOriginal = public_path($this->sliderOriginalImageUploadPath . $fileName);
                $pathThumb = public_path($this->sliderThumbImageUploadPath . $fileName);
                $bigThumb = public_path($this->sliderBigImageUploadPath . $fileName);
                Image::make($file->getRealPath())->save($pathOriginal);
                Image::make($file->getRealPath())->resize($this->sliderAdminImageWidth, $this->sliderAdminImageHeight)->save($pathThumb);
                Image::make($file->getRealPath())->resize($this->sliderBigImageWidth, $this->sliderBigImageHeight)->save($bigThumb);
                $sliderDetail['hps_image'] = $fileName;
            }
        }
        $response = $this->SliderRepository->saveSliderDetail($sliderDetail);
        if ($response) {
            if($response == 1)
            {
                return Redirect::to("admin/slider")->with('success', trans('adminlabels.slideraddsuccess'))->with('controller',$this->controller);
            }
            elseif ($response == 2) {
                return Redirect::to("admin/slider")->with('success', trans('adminlabels.sliderupdatesuccess'))->with('controller',$this->controller);
            }
        } else {
            return Redirect::to("admin/slider")->with('error', trans('adminlabels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getdata()
    {
        $data = Slider::select(['id', 'hps_image', 'hps_redirection_link', 'hps_display_status', 'deleted'])->whereRaw('deleted IN (1,2)');
        return Datatables::of($data)
            ->editColumn('deleted', '@if ($deleted == 1) <a href="{{ route(".data.editinactiveslider", $id) }}"> <i class="s_active fa fa-square"></i></a> @elseif($deleted == 2) <a href="{{ route(".data.editactiveslider", $id) }}"> <i class="s_inactive fa fa-square"></i> </a> @endif')
            ->editColumn('hps_image', '@if(File::exists(public_path("upload/slider/thumb_4_4/".$hps_image)) && $hps_image != NULL) <img src="{{ asset("upload/slider/thumb_4_4/".$hps_image) }}" />
                            @else
                            <img src="{{ asset("/backend/images/avatar5.png")}}" class="user-image" height="{{ Config::get("constant.SLIDER_ADMIN_IMAGE_HEIGHT") }}" width="{{ Config::get("constant.SLIDER_ADMIN_IMAGE_WIDTH") }}" alt="">
                            @endif')
            ->editColumn('hps_redirection_link', '<a href="{{$hps_redirection_link}}" target="blank"> {{$hps_redirection_link}}</a>')
            ->editColumn('hps_display_status', '@if ($hps_display_status == 0)Both @elseif($hps_display_status == 1) Loged in @elseif($hps_display_status == 2) Without Logged in @endif')
             

             ->add_column('actions', '<a href="{{ route(".data.editslider", $id) }}"> <span class="glyphicon glyphicon-edit text-primary" title="Edit"></span> </a>
                                           <a  href="{{ route(".data.deleteslider", $id) }}" onclick="return confirm(&#39<?php echo trans("adminlabels.confirmdelete"); ?>&#39;)"  > <span class="glyphicon glyphicon-remove-sign text-danger" title="Delete"></span> </a>')
            ->make(true);
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sliderDetail = $this->slider->find($id);
        return view('admin.EditSlider')->with('sliderDetail',$sliderDetail)->with('ThumbPath',$this->sliderThumbImageUploadPath)->with('controller',$this->controller);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $sliderDetail = $this->slider->find($id);
         $return = $this->SliderRepository->deleteSlider($id,$sliderDetail);
        if ($return) { return
         Redirect::to("admin/slider")->with('success', trans('adminlabels.sliderdeletesuccess'));
        } 
        else{
            return Redirect::to("admin/slider")->with('error', trans('adminlabels.commonerrormessage'));
        }
    }
     public function editactive($id)
    {
        $return = $this->SliderRepository->editactiveStatus($id);
        if($return)
        {
           
            return Redirect::to("admin/slider")->with('controller',$this->controller);
        }
        else
        {

            
            return Redirect::to("admin/slider")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }
    
    public function editinactive($id)
    {
        $return = $this->SliderRepository->editinactiveStatus($id);
        if($return)
        {
            
            return Redirect::to("admin/slider")->with('controller',$this->controller);
        }
        else
        {
           
            return Redirect::to("admin/slider")->with('error', trans('labels.commonerrormessage'))->with('controller',$this->controller);
        }
    }

}
