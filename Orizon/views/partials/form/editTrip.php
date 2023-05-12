


<form method="POST" action="/Orizon/editTrip" class="edit-form">
    <input type="text" value="<?= $trip->destination; ?>" name="new_destination" required>
    <input type="text" placeholder="<?= $trip->available_seats; ?>" name="available_seats" pattern="[0-9]+" required>
    <input type="hidden" name="trip_id" value="<?= $trip->id ?>">
    <button type="submit">Submit</button>
</form>