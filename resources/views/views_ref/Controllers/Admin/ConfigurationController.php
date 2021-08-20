<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigurationRequest;
use App\Services\Configuration\Contracts\ConfigurationRepository;
use Auth;
use Config;
use Helpers;
use Input;
use Redirect;

class ConfigurationController extends Controller
{
    public function __construct(ConfigurationRepository $ConfigurationRepository)
    {
        $this->middleware('auth.admin');
        $this->ConfigurationRepository = $ConfigurationRepository;
        $this->loggedInUser            = Auth::admin()->get();
        $this->controller              = 'ConfigurationController';
    }

    public function index()
    {
        
        $configuration      = [];
        $configurationArray = $this->ConfigurationRepository->getConfiguration();
        if ($configurationArray) {
            foreach ($configurationArray as $key=>$val) {
                $configuration[$val->c_key] = $val->c_value;
            }
        }      

        return view('admin.Configuration', compact('configuration'));
    }

    public function save(ConfigurationRequest $request)
    {
        $postRequest = Input::get();

        $status = $this->ConfigurationRepository->saveConfiguration($postRequest);
        if ($status) {         

            return Redirect::to("admin/setting")->with('success', 'General Setting updated successfully');
        }
    }
}
