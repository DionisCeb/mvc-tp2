<?php
namespace App\Models;

use App\Models\CRUD;

class Booking extends CRUD {
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $fillable = ['client_id', 'car_id', 'check_in_date', 'check_in_time', 'check_out_date', 'check_out_time'];

    public function getAllBookings() {
        $sql = "SELECT b.id AS booking_id, c.id AS client_id, ca.id AS car_id, c.name AS client_name, c.surname AS client_surname, 
                       c.email AS client_email, c.phone AS client_phone, 
                       b.check_in_date, b.check_in_time, b.check_out_date, b.check_out_time, 
                       ca.type AS car_type, ca.make AS car_make, ca.model AS car_model, ca.color AS car_color
                FROM booking b
                INNER JOIN client c ON b.client_id = c.id
                INNER JOIN car ca ON b.car_id = ca.id";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
