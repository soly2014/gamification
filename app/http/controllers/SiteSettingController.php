<?php

namespace Learncloud\Http\Controllers;

use Illuminate\Http\Request;

use Learncloud\Http\Requests;
use Learncloud\SiteSetting;
use Redirect;

class SiteSettingController extends Controller
{
    

    public function index()
    {

    	$site = SiteSetting::find(1);



    	return view('admin.sitesetting')->with('site',$site);
    }

    /* post site settings */
    public function postSettings(Request $request)
    {
           
    		$sitesettings = \Learncloud\SiteSetting::firstOrCreate(['id'=>1]);
                
            $sitesettings->fill($request->all())->save();


    	return Redirect::back()->with('success','oooops');
    }

}
