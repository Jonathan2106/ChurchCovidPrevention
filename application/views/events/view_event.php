<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css"/>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style>

<div class="container">
    <div class="row">
        <div class="col">
        <?php
            echo '<h2>'.$event_item['event_name'].'</h2>';
            echo '<b>'.date("d-m-Y", strtotime($event_item['event_date'])).'</b>    '.date("g:i A", strtotime($event_item['event_start'])).' - '.date("g:i A", strtotime($event_item['event_end']));
        ?>
        </div>
    </div>
</div>
<hr>
<br>
<div class="container">
    <div class="row">
        <div class="col">
            <table id="participant_table" class="table table-striped table-bordered table-light table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Attend</th>
                    </tr>
                </thead>

                <tbody id="participant_list">
                
                    <?php
                    foreach ($event_participant->result() as $row){
                        if(!strcmp($row->participant_arrival, NULL)){
                            echo '<tr>';
                            echo '  <td>'. $row->participant_name . '</td>';
                            echo '  <td> <a href="attend/'. $row->event_id . "/". $row->participant_id . '" class="btn btn-dark btn-block">attend</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>

                <tbody>
            </table>
            <br>
        </div>
    </div>
</div>
<hr>
<br>
<div class="container">
    <div class="row">
        <div class="col">
            <?php
                echo '<a href="../onsite/'. $event_item['event_id'] . '" class="btn btn-danger btn-block">On-site Registration</a></td>';
            ?>
        </div>
    </div><br>
    <div class="row">
        <div class="col">
            <?php
                echo '<a href="../summary/'. $event_item['event_id'] . '" class="btn btn-dark btn-block">Summary</a></td>';
            ?>
        </div>
    </div><br>
</div><br>

<script>
    $(document).ready(function() {
        $('#participant_table').DataTable();
    } );
</script>
