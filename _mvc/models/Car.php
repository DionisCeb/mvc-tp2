<?php
namespace App\Models;

class Car extends CRUD {
    protected $table = "car";
    protected $primaryKey = "id";
    protected $fillable = [
        'type', 'make', 'model', 'color'
    ];
}
