<?php
namespace App\Controllers;

use App\Providers\View;
use App\Providers\Validator;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Car;

class BookingController{


    public function create(){     
        $queryBuilder = new Booking();
        $listBookings = $queryBuilder->findAll();
        View::render('/home#reserve-sec', ['bookings' =>$listBookings]);
    }

    public function list(){     
        $queryBuilder = new Booking();
        $listBookings = $queryBuilder->findAll();
        View::render('booking/list', ['bookings' =>$listBookings]);
    }

    public function show($data = []) {
        if(isset($_GET['id']) && $data['id']!=null){
            $queryBuilder = new Booking();
            $bookingData = $queryBuilder->findOne((int)$data['id']);

            if($bookingData){
                return View::render('booking/details', ['booking'=>$bookingData]);
            } else {
                return View::render('error/error');
            }       
        }else{
            return View::render('error/error', ['msg'=>'Client not found!']);
        }    
    }

    public function edit($data = []) {
        if(isset($_GET['id']) && $data['id']!=null){
            $queryBuilder = new Booking();
            $bookingData = $queryBuilder->findOne((int)$data['id']);
            /* print_r($bookingData);
            die();  */
            if($bookingData){
                return View::render('booking/edit', ['booking'=>$bookingData]);
            } else {
                return View::render('error/error');
            }       
        }else{
            return View::render('error/error', ['msg'=>'Client not found!']);
        }    
    }

    public function update($data, $get_data) {
        if (isset($get_data['id']) && $get_data['id'] != null) {
            $id = $get_data['id'];
            // Validate booking data
            $validator = new Validator();
            $validator->field('check_in_date', $data['check_in_date'])->required()->date();
            $validator->field('check_in_time', $data['check_in_time'])->required()->time();
            $validator->field('check_out_date', $data['check_out_date'])->required()->date();
            $validator->field('check_out_time', $data['check_out_time'])->required()->time();
    
            // Validate client data
            $validator->field('name', $data['name'])->required()->min(3)->max(45);
            $validator->field('surname', $data['surname'])->required()->min(3)->max(45);
            $validator->field('email', $data['email'])->required()->email()->max(45);
            $validator->field('phone', $data['phone'])->required()->max(20);
    
            // Validate car data
            $validator->field('type', $data['type'])->required();
            $validator->field('make', $data['make'])->required();
            $validator->field('model', $data['model'])->required();
            $validator->field('color', $data['color'])->required();
    
            


            if ($validator->isSuccess()) {
                /* var_dump($data);
                die; */
               
    
                // Update client data or create if doesn't exist by email
                $client = new Client();
                $clientData = $client->findByEmail($data['email']);
                if ($clientData) {
                    $clientId = $clientData['id'];
                    //If we found the client in the DB we will still allow user to update the client data, except email
                    $updateClient = $client->update([
                        'name' => $data['name'],
                        'surname' => $data['surname'],
                        'phone' => $data['phone']
                    ], $clientId);
                    if (!$updateClient) {
                        return View::render('error/error', ['msg' => 'Client has not been updated!']);
                    }
                } else {
                    $clientId = $client->insert([
                        'name' => $data['name'],
                        'surname' => $data['surname'],
                        'phone' => $data['phone'],
                        'email' => $data['email'],
                    ]);
                    
                    if (!$clientId) {
                        return View::render('error', ['msg' => 'Client has not been created!']);
                    } 
                }
    
                // Create car data if not exist by type/make/model/color
                $car = new Car();
                $carData = $car->findOneByFilters([
                    'type' => $data['type'],
                    'make' => $data['make'],
                    'model' => $data['model'],
                    'color' => $data['color'],
                ]);
                if ($carData) {
                    $carId = $carData['id'];
                    // var_dump("CAR found");
                    // var_dump($carData);
                } else {
                    $carId = $car->insert([
                        'type' => $data['type'],
                        'make' => $data['make'],
                        'model' => $data['model'],
                        'color' => $data['color'],
                    ]);
                    
                    if (!$carId) {
                        return View::render('error', ['msg' => 'Car has not been created!']);
                    } 
                }

                // var_dump("CAR");
                // var_dump($carId);
                // var_dump("CLIENT");
                // var_dump($clientId);
                // die;

               
                $booking = new Booking();
                $updated = $booking->update([
                    'car_id' => $carId,
                    'client_id' => $clientId,
                    'check_in_date' => $data['check_in_date'],
                    'check_in_time' => $data['check_in_time'],
                    'check_out_date' => $data['check_out_date'],
                    'check_out_time' => $data['check_out_time'],
                    'updated_at' => date('Y-m-d H:i:s')
                ], $id);

                // var_dump("Booking");
                // var_dump($id);
                // var_dump("updated");
                // var_dump($updated);
                // die;
                if($updated) {
                    return View::redirect('bookings');
                } else {
                    return View::render('booking/edit', ['errors' => ["Error: Update didn't go through"], 'booking' => $data]);
                }
            } else {
                $errors = $validator->getErrors();
                // var_dump($errors);
                // die;
                return View::render('booking/edit', ['errors' => $errors, 'booking' => $data]);
            }
        } else {
            return View::render('error/error');
        }
    }
    

    public function delete($data){
        if (!isset($_POST['id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking id has not been passed'
            ]);
            return;
        }

        $bookingId = (int)$data['id'];
        $booking = new Booking();
        $deleted = $booking->delete($bookingId);

        if($deleted){
           echo json_encode([
                'status' => 'success',
                'message' => 'Booking deleted successfully, element with id: ' . $bookingId
           ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking not found'
            ]);
        }
    }
}

?>