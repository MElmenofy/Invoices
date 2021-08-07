<?php

namespace App;
use App\sections;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo('App\sections');
    }

}
