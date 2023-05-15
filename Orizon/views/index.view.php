<?php require('partials/head.php'); ?>
<h1>Orizon</h1>
<main>
    <div class="form">
        <div>
            <h2>Submit country</h2>
            <?php require('partials/form/form-country.php'); ?>
        </div>
        <div>
            <h2>Submit trip</h2>
            <?php require('partials/form/form-trip.php'); ?>
        </div>
    </div>
    <div class="results">
        <div class="countries section">
            <h2>Countries</h2>
            <ul class>
                <?php foreach ($countries as $country) : ?>
                    <li class="display">
                        <p><?= $country->country_name; ?></p>
                        <?php require('partials/form/editCountry.php'); ?>
                        <?php require('partials/btn-group/btn-country.php'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="trips section">
            <h2>Trips</h2>
            <ul>
                <?php foreach ($trips as $trip) : ?>
                    <li class="display">
                        <p>
                            Destination: <?= $trip->destination; ?></br>
                            Available seats: <?= $trip->available_seats; ?>
                        </p>
                        <?php require('partials/form/editTrip.php'); ?>
                        <?php require('partials/btn-group/btn-trip.php'); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="filtered-trips section">
            <h2>Available Trips</h2>
            <ul>
                <?php foreach ($available_trips as $available_trips) : ?>
                    <li class="display">
                        <p>
                            Destination: <?= $available_trips->destination; ?></br>
                            Available seats: <?= $available_trips->available_seats; ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</main>
</body>

</html>