<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    public function section(){
        return $this->belongsTo('App\sections');
    }
}


