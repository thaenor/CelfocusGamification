<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PointSettings extends Model {

    public static function updatePointSystem($newPointSystem)
    {
        $pointSet = PointSettings::find(1);
        $pointSet->critical_point_val = $newPointSystem['p1PointVal'];
        $pointSet->high_point_val = $newPointSystem['p2PointVal'];
        $pointSet->medium_point_val = $newPointSystem['p3PointVal'];
        $pointSet->low_point_val = $newPointSystem['p4PointVal'];
        $pointSet->inc_point_val = $newPointSystem['incidentPointVal'];
        $pointSet->problem_point_val = $newPointSystem['problemPointVal'];
        $pointSet->servreq_point_val = $newPointSystem['serviceReqPointVal'];
        $pointSet->warning_percent = $newPointSystem['warning_percentage'];
        $pointSet->penalty_percent = $newPointSystem['penalty_percentage'];
        $pointSet->save();
	}

}
