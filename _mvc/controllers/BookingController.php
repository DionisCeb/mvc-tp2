<?php
namespace App\Controllers;

use App\Models\Booking;
use App\Providers\View;

class BookingController {
    public function index() {
        $booking = new Booking();
        $bookings = $booking->getBookingsWithDetails();  // Fetch bookings with client and car details
        View::render('booking/index', ['bookings' => $bookings]);
    }

    // Other methods (create, show, edit, store, update, delete) can be similar to before
}
?>