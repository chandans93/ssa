<?php

namespace App\Http\Controllers\Front;

use App\CMS;
use App\Http\Controllers\Controller;
use App\Services\CMS\Contracts\CMSRepository;
use Config;
use Helpers;

class CMSController extends Controller
{
    public function __construct(CMSRepository $CMSRepository)
    {
        $this->CMSRepository = $CMSRepository;
        $this->controller    = 'CMSController';
    }

    public function getCMSContent($slug)
    {
        $cmsDetail = $this->CMSRepository->getCMSBySlug($slug);
        return view('front.CMS', compact('cmsDetail'));
    }
}

?>
