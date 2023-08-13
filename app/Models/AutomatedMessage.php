<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomatedMessage extends Model
{
    use HasFactory;

    protected $guarded = array();

    public $table = "automated_message";

    public function user()
	{
		return $this->belongsTo('App\Models\User')->first();
	}
}
