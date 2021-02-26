<h2><?php echo $title; ?></h2>
<br>
<?php echo form_open('events/add'); ?>

    <div class="form-group ">
        <label for="event_name">Event Name</label><br>
        <input type="text" id="event_name" name="event_name" class="form-control" placeholder="Enter Event Name" required><br>
    </div>
    <div class="form-group">    
        <label for="event_date">Event Date</label><br>
        <input type="date" id="event_date" name="event_date" class="form-control" required><br>
    </div>
    <div class="form-group">
        <label for="event_start">Event Start</label><br>
        <input type="time" id="event_start" name="event_start" class="form-control" required><br>
        </div>
    <div class="form-group">
        <label for="event_end">Event End</label><br>
        <input type="time" id="event_end" name="event_end" class="form-control" required><br>
    </div>

    <input type="submit" value="add event" class="btn btn-dark btn-block">

</form>