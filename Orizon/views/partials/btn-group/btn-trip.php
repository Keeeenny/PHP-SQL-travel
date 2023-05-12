<div class="btn">
    <!-- edit button -->
    <input type="checkbox" class="checkbox">
    <!-- delete button -->
    <form method="POST" action="/Orizon/removeTrip">
        <input type="hidden" name="id" value="<?= $trip->id ?>">
        <button type="submit">x</button>
    </form>
</div>