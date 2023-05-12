




<form method="POST" action="/Orizon/editCountry" class="edit-form">
    <input type="text" placeholder="<?= $country->country_name; ?>" name="new_name" required>
    <input type="hidden" name="country_id" value="<?= $country->id ?>">
    <button type="submit" class="submit">Submit</button>
</form>



