<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'id_admin', 'id_customer', 'pesan', 'status'
    ];
}
