<?php
namespace App\Models;
use App\Models\DB\CRUD;

class Booking extends CRUD{

    protected $table = "booking";
    protected $primaryKey = "id";
    protected $fillable = ['car_id', 'client_id', 'check_in_date', 'check_in_time', 'check_in_time', 'check_out_date'];

    /**
     * Find all bookings with the asociated clients and cars
     */
    public function findAll() {
        $sql = "SELECT b.id AS booking_id, c.id AS client_id, ca.id AS car_id, c.name AS client_name, c.surname AS client_surname, 
               c.email AS client_email, c.phone AS client_phone, 
               b.check_in_date, b.check_in_time, b.check_out_date, b.check_out_time, 
               ca.type AS car_type, ca.make AS car_make, ca.model AS car_model, ca.color AS car_color
        FROM booking b
        INNER JOIN client c ON b.client_id = c.id
        INNER JOIN car ca ON b.car_id = ca.id";
        $stmt = $this->query($sql);
        $bookings = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $bookings;
    }

    /**
     * Get one booking with the asociated clients' and cars' information
     */
    public function findOne(int $booking_id) {
        $sql = "SELECT 
            b.id AS booking_id, 
            c.id AS client_id, 
            c.name AS client_name, 
            c.surname AS client_surname, 
            c.email AS client_email, 
            c.phone AS client_phone, 
            b.check_in_date, 
            b.check_in_time, 
            b.check_out_date, 
            b.check_out_time, 
            car.id AS car_id,  -- Add this line
            car.type AS car_type, 
            car.make AS car_make, 
            car.model AS car_model, 
            car.color AS car_color 
        FROM 
            booking b 
            INNER JOIN client c ON b.client_id = c.id 
            INNER JOIN car ON b.car_id = car.id 
        WHERE 
            b.id = :booking_id";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(':booking_id', $booking_id, \PDO::PARAM_INT);
        $stmt->execute();

        $booking = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $booking;

    }
    
} 