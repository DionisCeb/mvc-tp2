{{ include('layouts/header.php', {title:'Bookings'})}}

<section class="admin-interface">
        <div class="admin-container">
            <h1>Gestion des réservations</h1>
            <table class="booking-list-table">
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Date d'arrivée</th>
                    <th>L'heure d'arrivée</th>
                    <th>Jour de retour</th>
                    <th>L'heure de retour</th>
                    <th>Type de voiture</th>
                    <th>Marque de voiture</th>
                    <th>Modèle de voiture</th>
                    <th>Couleur de la voiture</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                {% for booking in bookings %}
                <tr>
                    <td><a href="{{base}}/booking/show?id={{booking.booking_id}}">{{ booking.booking_id }}</a></td>
                    <td>{{booking.client_name}}</td>
                    <td>{{booking.client_surname}}</td>
                    <td>{{booking.client_email}}</td>
                    <td>{{booking.client_phone}}</td>
                    <td>{{booking.check_in_date}}</td>
                    <td>{{booking.check_in_time}}</td>
                    <td>{{booking.check_out_date}}</td>
                    <td>{{booking.check_out_time}}</td>
                    <td>{{booking.car_type}}</td>
                    <td>{{booking.car_make}}</td>
                    <td>{{booking.car_model}}</td>
                    <td>{{booking.car_color}}</td>
                    
                    <!-- <td><a href="{{base}}/booking/show?id={{booking.booking_id}}">{{ booking.booking_id }}</a></td> -->
                    <td><a href="{{base}}/booking?booking_id={{ booking.booking_id }}" class="booking-list-btn edit-btn">Modifier</a></td>
                    <td><a href="{{base}}/booking?id={{ booking.booking_id }}" class="booking-list-btn delete-btn">Supprimer</a></td>
                </tr>
                {% endfor %}
            </table>
        </div>

        <a href="index.php#reserve-sec" class="header-box_btn deals-link return-secondary-btn secondary-edit-btn">Nouvelle réservation</a>
    </section>

{{ include('layouts/footer.php')}}