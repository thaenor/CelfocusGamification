<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model {

    public function user()
    {
        return $this->hasMany('User');
    }

}
