<div class="btn">
    <!-- edit button -->
    <input type="checkbox" class="checkbox">
    <!-- delete button -->
    <form method="POST" action="/Orizon/removeCountry">
        <input type="hidden" name="id" value="<?= $country->id ?>">
        <button type="submit">x</button>
    </form>
</div>