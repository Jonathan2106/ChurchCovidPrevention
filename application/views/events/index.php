<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css"/>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>


<h2><?php echo $title; ?></h2>
 


<div class="row">
    <div class="col">
        <table id="events" class="table table-striped table-bordered table-light table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Manage</th>
                    <th>Summary</th>
					<th>Hide</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($events as $events_item): ?>

                    <tr>
                        <td><a href="events/<?php echo $events_item['event_id']; ?>"><?php echo $events_item['event_name']; ?></a><br><span style="font-size: smaller;"><?php echo '<b>'.date("d-m-Y", strtotime($events_item['event_date'])).'</b>    '.date("g:i A", strtotime($events_item['event_start'])).' - '.date("g:i A", strtotime($events_item['event_end'])); ?></span></td>
                        <td><a href="manage/<?php echo $events_item['event_id']; ?>">Manage</a></td>
                        <td><a href="summary/<?php echo $events_item['event_id']; ?>">Summary</a></td>
						<td><a href="hide/<?php echo $events_item['event_id']; ?>">Hide</a></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>

        </table>
     </div>
</div><br>
<div class="row">
    <div class="col">
           <a href="events/new_event" class="btn btn-dark btn-block">New Event</a>
    </div>
</div><br>

<script>
$(document).ready(function() {
    $('#events').DataTable();
} );
</script>
