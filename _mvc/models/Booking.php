<?php
namespace App\Models;

class Booking extends CRUD {
    protected $table = "booking";
    protected $primaryKey = "id";
    protected $fillable = [
        'car_id', 'client_id', 'check_in_date', 'check_in_time', 
        'check_out_date', 'check_out_time'
    ];

    // Method to get bookings with related client and car information
    public function getBookingsWithDetails() {
        $sql = "SELECT b.*, c.name AS client_name, ca.make AS car_make 
                FROM {$this->table} b
                JOIN client c ON b.client_id = c.id
                JOIN car ca ON b.car_id = ca.id";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
}
