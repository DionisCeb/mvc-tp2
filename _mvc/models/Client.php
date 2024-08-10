<?php
namespace App\Models;

class Client extends CRUD {
    protected $table = "client";
    protected $primaryKey = "id";
    protected $fillable = [
        'name', 'surname', 'email', 'phone'
    ];
}
