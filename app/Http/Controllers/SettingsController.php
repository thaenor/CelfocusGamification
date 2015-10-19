<?php namespace App\Http\Controllers;

use Request;
use App\Http\Controllers\Controller;

use App\PointSettings;

class SettingsController extends Controller {

	/**
	 * Display settings page.
	 *
	 * @return Response
	 */
	public function index()
	{
		$settings = PointSettings::all();
		return view('settings.index',compact('settings'));
	}

	/**
	 * Update point system in database.
	 *
	 * @return Response
	 */
	public function storePoints()
	{
        $input = Request::all();
        if($input['p1PointVal'] <= 100 && $input['p2PointVal'] <= 100 && $input['p3PointVal'] <= 100 && $input['p4PointVal'] <= 100 && $input['incidentPointVal'] <= 100 && $input['problemPointVal'] <= 100 && $input['serviceReqPointVal'] <= 100 && $input['warning_percentage'] <= 100 && $input['penalty_percentage'] <= 100 )
        {
            if($input['p1PointVal'] > 0 && $input['p2PointVal'] > 0 && $input['p3PointVal'] > 0 && $input['p4PointVal'] > 0 && $input['incidentPointVal'] > 0 && $input['problemPointVal'] > 0 && $input['serviceReqPointVal'] > 0 && $input['warning_percentage'] > 0 && $input['penalty_percentage'] > 0 )
            {
                PointSettings::updatePointSystem(Request::all());
            }else { return "invalid point settings"; }
        }else { return "invalid point settings"; }
        return "points updated successfully";
	}



}
