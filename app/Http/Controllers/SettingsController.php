<?php namespace App\Http\Controllers;

use App\User;
use App\user_blacklist;
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
        $blacklist = user_blacklist::all();
        $blacklistString = "";
        foreach($blacklist as $element){
            $blacklistString= $blacklistString. $element->username.",";
        }
		return view('settings.index',compact('settings','blacklistString'));
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

    public function storeBlackList()
    {
        $input = Request::all();
        $response = explode(",", $input['blacklist']);
        foreach($response as $elment){
            $user = User::where('full_name',$elment)->get();
            $blacklist = new user_blacklist();
            $blacklist->user_id = $user[0]->id;
            $blacklist->username = $user[0]->full_name;
						$blacklist->save();
        }
        return 'recorded data successfully';
    }

}
