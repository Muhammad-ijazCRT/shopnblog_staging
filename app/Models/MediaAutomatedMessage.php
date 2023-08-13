<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaAutomatedMessage extends Model
{
    use HasFactory;

    public $table = "media_automated_message";

    protected $fillable = [
        'welcome_messages_id',
        'type',
        'price',
        'user_id',
        'file',
        'created_at'
      ];
    
}
