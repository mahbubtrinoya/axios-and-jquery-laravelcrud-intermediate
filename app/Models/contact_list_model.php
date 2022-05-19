<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact_list_model extends Model
{

    protected $table = 'contact_list';
    protected $primaryKey = 'id';
    public $incrementing = True;
    protected $keyType = 'int';
}
