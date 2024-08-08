<?php
require_once 'classes/CRUD.php';

// Initialize variables
$booking = [];
$updateSuccess = false;
$updateError = '';

// Check if booking_id is provided in the URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    try {
        $crud = new CRUD();

        // Fetch booking details
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

        $stmt = $crud->prepare($sql);
        $stmt->bindValue(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $updateError = "Erreur : " . $e->getMessage();
    }
}

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Retrieve form data
    $car_type = $_POST['cars'];
    $car_make = $_POST['make'];
    $car_model = $_POST['model'];
    $car_color = $_POST['color'];
    $check_in_date = $_POST['check-in-date'];
    $check_in_time = $_POST['check-in-time'];
    $check_out_date = $_POST['check-out-date'];
    $check_out_time = $_POST['check-out-time'];
    $client_name = $_POST['nom'];
    $client_surname = $_POST['prenom'];
    $client_email = $_POST['email'];
    $client_phone = $_POST['telephone'];

    try {
        $crud->beginTransaction();

        // Update car information
        $carData = array(
            'type' => $car_type,
            'make' => $car_make,
            'model' => $car_model,
            'color' => $car_color
        );
        $car_id = $crud->update('car', $carData, $booking['car_id']);

        // Update client information
        $clientData = array(
            'name' => $client_name,
            'surname' => $client_surname,
            'email' => $client_email,
            'phone' => $client_phone,
        );
        $client_id = $crud->update('client', $clientData, $booking['client_id']);

        // Update booking information
        $bookingData = array(
            'check_in_date' => $check_in_date,
            'check_in_time' => $check_in_time,
            'check_out_date' => $check_out_date,
            'check_out_time' => $check_out_time,
        );
        $crud->update('booking', $bookingData, $booking_id);

        $crud->commit();
        $updateSuccess = true;

    } catch (PDOException $e) {
        $crud->rollBack();
        $updateError = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Modifier la réservation</title>
</head>
<body>
    <section class="form-section">
        <div class="structure">
            <div class="form-box form-box-center">
                <div class="form-title">
                    <h1>Modifier la réservation numéro <?php echo htmlspecialchars($booking['booking_id']); ?> de <?php echo htmlspecialchars($booking['client_name'] . ' ' . $booking['client_surname']); ?></h1>
                </div>
                <form class="form-reservation" method="post" action="">
                    <select name="cars" id="cars">
                        <option value="">Choisir le type</option>
                        <option value="compact" <?php if ($booking['car_type'] === 'compact') echo 'selected'; ?>>Compacte</option>
                        <option value="sport" <?php if ($booking['car_type'] === 'sport') echo 'selected'; ?>>Sport</option>
                        <option value="suv" <?php if ($booking['car_type'] === 'suv') echo 'selected'; ?>>SUV</option>
                        <option value="luxury" <?php if ($booking['car_type'] === 'luxury') echo 'selected'; ?>>Voitures de luxe</option>
                        <option value="sedan" <?php if ($booking['car_type'] === 'sedan') echo 'selected'; ?>>Sedan</option>
                    </select>
                    <select name="make" id="make">
                        <option value="">Choisir la marque</option>
                        <option value="audi" <?php if ($booking['car_make'] === 'audi') echo 'selected'; ?>>Audi</option>
                        <option value="mercedes" <?php if ($booking['car_make'] === 'mercedes') echo 'selected'; ?>>Mercedes</option>
                        <option value="toyota" <?php if ($booking['car_make'] === 'toyota') echo 'selected'; ?>>Toyota</option>
                        <option value="gmc" <?php if ($booking['car_make'] === 'gmc') echo 'selected'; ?>>GMC</option>
                    </select>
                    <select name="model" id="model">
                        <option value="">Choisir le modèle</option>
                        <option value="audi A3" <?php if ($booking['car_model'] === 'audi A3') echo 'selected'; ?>>A3</option>
                        <option value="audi A4" <?php if ($booking['car_model'] === 'audi A4') echo 'selected'; ?>>A4</option>
                        <option value="audi R8" <?php if ($booking['car_model'] === 'audi R8') echo 'selected'; ?>>R8</option>
                        <option value="mercedes C-class" <?php if ($booking['car_model'] === 'mercedes C-class') echo 'selected'; ?>>C-class</option>
                        <option value="mercedes A-class" <?php if ($booking['car_model'] === 'mercedes A-class') echo 'selected'; ?>>A-class</option>
                        <option value="mercedes S-class" <?php if ($booking['car_model'] === 'mercedes S-class') echo 'selected'; ?>>S-class</option>
                        <option value="toyota Supra" <?php if ($booking['car_model'] === 'toyota Supra') echo 'selected'; ?>>Supra</option>
                        <option value="toyota Tacoma" <?php if ($booking['car_model'] === 'toyota Tacoma') echo 'selected'; ?>>Tacoma</option>
                        <option value="toyota Tundra" <?php if ($booking['car_model'] === 'toyota Tundra') echo 'selected'; ?>>Tundra</option>
                        <option value="ford F-150" <?php if ($booking['car_model'] === 'ford F-150') echo 'selected'; ?>>F-150</option>
                    </select>
                    <select name="color" id="color">
                        <option value="">Choisir la couleur</option>
                        <option value="white" <?php if ($booking['car_color'] === 'white') echo 'selected'; ?>>Blanche</option>
                        <option value="gray" <?php if ($booking['car_color'] === 'gray') echo 'selected'; ?>>Grise</option>
                        <option value="black" <?php if ($booking['car_color'] === 'black') echo 'selected'; ?>>Noire</option>
                        <option value="blue" <?php if ($booking['car_color'] === 'blue') echo 'selected'; ?>>Bleue</option>
                    </select>
                    <div class="check-in">
                        <input type="date" id="check-in-date" name="check-in-date" value="<?php echo htmlspecialchars($booking['check_in_date']); ?>" required>
                        <input type="time" id="check-in-time" name="check-in-time" value="<?php echo htmlspecialchars($booking['check_in_time']); ?>" required>
                    </div>

                    <div class="check-out">
                        <input type="date" id="check-out-date" name="check-out-date" value="<?php echo htmlspecialchars($booking['check_out_date']); ?>" required>
                        <input type="time" id="check-out-time" name="check-out-time" value="<?php echo htmlspecialchars($booking['check_out_time']); ?>" required>
                    </div>
                    <div class="name-surname">
                        <input type="text" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars($booking['client_name']); ?>" required>
                        <input type="text" name="prenom" placeholder="Prénom" value="<?php echo htmlspecialchars($booking['client_surname']); ?>" required>
                    </div>
                    <div class="email-phone">
                        <input type="email" name="email" placeholder="email@gmail.com" value="<?php echo htmlspecialchars($booking['client_email']); ?>" required>
                        <input type="tel" name="telephone" placeholder="+1 439 678 9091" value="<?php echo htmlspecialchars($booking['client_phone']); ?>" required>
                    </div>
                    <div class="reserve-submit">
                        <button type="submit" name="update" class="header-box_btn deals-link return-primary-btn">Modifier</button>
                        <a href="booking-list.php" class="header-box_btn deals-link return-secondary-btn">Afficher les réservations</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
