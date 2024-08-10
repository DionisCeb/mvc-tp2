<?php
namespace App\Controllers;

use App\Providers\View;

class HomeController{
    public function index(){
        //echo 'Home Controller';
        /* $model = new ExampleModel;
        $data = $model->getData();
        */
        /* include('views/home.php'); */
        View::render('home', []);
    }

    public function test(){
        echo 'test';
    }
}

?>