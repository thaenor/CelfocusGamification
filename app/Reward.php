<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model {

    public function user()
    {
        return $this->belongsTo('User');
    }

}
