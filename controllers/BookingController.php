<?php
namespace App\Controllers;

use App\Providers\View;
use App\Models\Booking;

class BookingController{
    public function list(){
        
        $queryBuilder = new Booking;
        $listBookings = $queryBuilder->findAll();
        /* print_r($listBookings);
        die(); */
        View::render('booking/list', ['bookings' =>$listBookings]);
    }

    public function show($data = []) {
        if(isset($_GET['id']) && $data['id']!=null){
            $queryBuilder = new Booking;
            $bookingData = $queryBuilder->findOne((int)$data['id']);
            /* print_r($bookingData);
            die();  */
            if($bookingData){
                return View::render('booking/edit', ['booking'=>$bookingData]);
            } else {
                return View::render('error');
            }       
        }else{
            return View::render('error', ['msg'=>'Client not found!']);
        }    
    }
}

?>