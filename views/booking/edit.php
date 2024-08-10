{{ include('layouts/header.php', {title:'Booking'})}}

<section class="form-section">
        <div class="structure">
            <div class="form-box form-box-center">
                <div class="form-title">
                    <h1>Modifier la réservation numéro {{booking.booking_id}} de {{booking.client_name}} {{booking.client_surname}}</h1>
                </div>
                <form class="form-reservation" method="post" action="">
                    <select name="cars" id="cars">
                        <option value="">Choisir le type</option>
                        <option value="compact" {% if booking.car_type == 'compact' %}selected{% endif %}>Compacte</option>
                        <option value="sport" {% if booking.car_type == 'sport' %}selected{% endif %}>Sport</option>
                        <option value="suv" {% if booking.car_type == 'suv' %}selected{% endif %}>SUV</option>
                        <option value="luxury" {% if booking.car_type == 'luxury' %}selected{% endif %}>Voitures de luxe</option>
                        <option value="sedan" {% if booking.car_type == 'sedan' %}selected{% endif %}>Sedan</option>
                    </select>

                    <select name="make" id="make">
                        <option value="">Choisir la marque</option>
                        <option value="audi" {% if booking.car_make == 'audi' %}selected{% endif %}>Audi</option>
                        <option value="mercedes" {% if booking.car_make == 'mercedes' %}selected{% endif %}>Mercedes</option>
                        <option value="toyota" {% if booking.car_make == 'toyota' %}selected{% endif %}>Toyota</option>
                        <option value="gmc" {% if booking.car_make == 'gmc' %}selected{% endif %}>GMC</option>
                    </select>


                    <select name="model" id="model">
                        <option value="">Choisir le modèle</option>
                        <option value="audi A3" {% if booking.car_model == 'audi A3' %}selected{% endif %}>A3</option>
                        <option value="audi A4" {% if booking.car_model == 'audi A4' %}selected{% endif %}>A4</option>
                        <option value="audi R8" {% if booking.car_model == 'audi R8' %}selected{% endif %}>R8</option>
                        <option value="mercedes C-class" {% if booking.car_model == 'mercedes C-class' %}selected{% endif %}>C-class</option>
                        <option value="mercedes A-class" {% if booking.car_model == 'mercedes A-class' %}selected{% endif %}>A-class</option>
                        <option value="mercedes S-class" {% if booking.car_model == 'mercedes S-class' %}selected{% endif %}>S-class</option>
                        <option value="toyota Supra" {% if booking.car_model == 'toyota Supra' %}selected{% endif %}>Supra</option>
                        <option value="toyota Tacoma" {% if booking.car_model == 'toyota Tacoma' %}selected{% endif %}>Tacoma</option>
                        <option value="toyota Tundra" {% if booking.car_model == 'toyota Tundra' %}selected{% endif %}>Tundra</option>
                        <option value="ford F-150" {% if booking.car_model == 'ford F-150' %}selected{% endif %}>F-150</option>
                    </select>

                    <select name="color" id="color">
                        <option value="">Choisir la couleur</option>
                        <option value="white" {% if booking.car_color == 'white' %}selected{% endif %}>Blanche</option>
                        <option value="gray" {% if booking.car_color == 'gray' %}selected{% endif %}>Grise</option>
                        <option value="black" {% if booking.car_color == 'black' %}selected{% endif %}>Noire</option>
                        <option value="blue" {% if booking.car_color == 'blue' %}selected{% endif %}>Bleue</option>
                    </select>
                    <div class="check-in">
                        <input type="date" id="check-in-date" name="check-in-date" value="{{booking.check_in_date}}" required>
                        <input type="time" id="check-in-time" name="check-in-time" value="{{booking.check_in_time}}" required>
                    </div>

                    <div class="check-out">
                        <input type="date" id="check-out-date" name="check-out-date" value="{{booking.check_out_date}}" required>
                        <input type="time" id="check-out-time" name="check-out-time" value="{{booking.check_out_time}}" required>
                    </div>
                    <div class="name-surname">
                        <input type="text" name="nom" placeholder="Nom" value="{{booking.client_name}}" required>
                        <input type="text" name="prenom" placeholder="Prénom" value="{{booking.client_surname}}" required>
                    </div>
                    <div class="email-phone">
                        <input type="email" name="email" placeholder="email@gmail.com" value="{{booking.client_email}}" required>
                        <input type="tel" name="telephone" placeholder="+1 439 678 9091" value="{{booking.client_phone}}" required>
                    </div>
                    <div class="reserve-submit">
                        <button type="submit" name="update" class="header-box_btn deals-link return-primary-btn">Modifier</button>
                        <a href="booking-list.php" class="header-box_btn deals-link return-secondary-btn">Afficher les réservations</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

{{ include('layouts/footer.php')}}