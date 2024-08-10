<?php
namespace App\Controllers;

use App\Models\Car;
use App\Providers\View;
use App\Providers\Validator;

class CarController {
    public function index() {
        $car = new Car();
        $cars = $car->select();
        View::render('car/index', ['cars' => $cars]);
    }

    public function create() {
        View::render('car/create');
    }

    public function show($data = []) {
        if (isset($data['id']) && $data['id'] != null) {
            $car = new Car();
            $carData = $car->selectId($data['id']);
            if ($carData) {
                return View::render('car/show', ['car' => $carData]);
            } else {
                return View::render('error', ['msg' => 'Car not found!']);
            }
        } else {
            return View::render('error', ['msg' => 'Car ID not provided!']);
        }
    }

    // Other methods: edit, store, update, delete
}




?>