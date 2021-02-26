<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css"/>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>

<?php
    $t30 = 0;
    $t25 = 0;
    $t18 = 0;
    $t10 = 0;
    $t5 = 0;

?>
<style>
table.dataTable tbody td {
  vertical-align: middle;
}


.mar-bot{
    margin-bottom: 100px;
}
</style>

<div class="container">
    <div class="row">
        <div class="col">   
        <?php
            echo '<h2>'.$event_item['event_name'].'</h2>';
            echo '<b>'.date("d-m-Y", strtotime($event_item['event_date'])).'</b>    '.date("g:i A", strtotime($event_item['event_start'])).' - '.date("g:i A", strtotime($event_item['event_end']));
            $start = strtotime($event_item['event_date'].' '.$event_item['event_start']);
        ?>
        </div>
    </div><br>
</div>
<br>

<div class="container">
    <div class="row">
        <div class="col">
            <?php
                echo '<a href="../summary/'. $event_item['event_id'] . '" class="btn btn-dark btn-block">Summary</a></td>';
            ?>
        </div>
    </div><br>
    <div class="row">
        <div class="col">
            <?php
                echo '<a href="../add_participant/'. $event_item['event_id'] . '" class="btn btn-warning btn-block">+ Add Participant</a></td>';
            ?>
        </div>
    </div><br>
    <div class="row">
        <div class="col">
            <?php
                echo '<a href="../add_committee/'. $event_item['event_id'] . '" class="btn btn-success btn-block">+ Add Committee</a></td>';
            ?>
        </div>
    </div><br>
</div><br>

<hr>

<div class="container">
    <div class="row">
        <div class="col">
            <table id="participant_table" class="table table-striped table-bordered table-light table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Arrival Time</th>
                        <th>On-Site</th>
                        <th>Pelayan</th>
                    </tr>
                </thead>

                <tbody id="participant_list">
                
                    <?php
                    $col = "";
                    foreach ($event_participant->result() as $row){
                        echo '<tr>';
                        echo '  <td>'. $row->participant_name . '</td>';
                        echo '  <td>'. $row->participant_email . '</td>';
                        $new_date_format = "";
                        if ($row->participant_arrival != NULL){
                            //$attended_participant++;
                            $timestamp = strtotime($row->participant_arrival);
                            $new_date_format = date('H:i', $timestamp);
                            $late = $timestamp - $start;

                            if($late > 0){
                                if($late > 30 * 60){
                                    $col = "#F11D28";
                                    $t30++;
                                }else if($late > 25 * 60){
                                    $col = "#FE612C";
                                    $t25++;
                                }else if($late > 18 * 60){
                                    $col = "#FF872C";
                                    $t18++;
                                }else if($late > 10 * 60){
                                    $col = "#FFA12C";
                                    $t10++;
                                }else if($late > 5 * 60){
                                    $col = "#292b2c";
                                    $t5++;
                                }
                            }else{
                                $col = "#0275d8";
                            }
                            echo '  <td style="color:'.$col.'">'. $new_date_format . '</td>';
                        } else echo '  <td></td>';

                        if ($row->participant_onsite == 0){
                            echo '  <td></td>';
                        }else{
                            echo '  <td style="text-align:center;vertical-align:middle;color: #F11D28;">✘</td>';
                        }
                        if ($row->participant_committee == 0){
                            echo '  <td></td>';
                        }else{
                            echo '  <td style="text-align:center;vertical-align:middle;color: #0B6623;">✓</td>';
                        }
                        echo '</tr>';
                    }
                    ?>

                <tbody>
            </table>
            <br>
        </div>
    </div><br>
</div><br>

<div class="container">
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-danger btn-block" onClick="onlyOnsite()">On-Site</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-info btn-block" onClick="onlyArrived()">Jemaat Hadir</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-success btn-block" onClick="onlyCommittee()">Pelayan</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-dark btn-block" onClick="resetTable()">Reset</button>
        </div>
    </div>
</div>
<br>

<br>
<div clas="jumbotron">
    <div class="row mar-bot">
        <div class="col-md-3 text-center">
            <h2>
            <?php
                echo $participant .'<br>';
            ?>
            </h2>
            <br>
            <h3> Jemaat Terdaftar</h3>
        </div>
        <div class="col-md-3 text-center">
            <h2>
            <?php
                echo $onsite.'<br>';
            ?>
            </h2>
            <br>
            <h3> On-Site</h3>
        </div>
        <div class="col-md-3 text-center">
            <h2>
            <?php
                echo $attended_participant .'<br>';
            ?>
            </h2>
            <br>
            <h3>Jemaat Hadir</h3>
        </div>
        <div class="col-md-3 text-center">
            <h2>
            <?php
                echo $committee.'<br>';
            ?>
            </h2>
            <br>
            <h3> Pelayan</h3>
        </div>
    </div>
</div>
<br>


<script>
    var table = $('#participant_table').DataTable();

    function onlyOnsite() {
        table.column(2).search("").draw()
        table.column(3).search("✘").draw()
        table.column(4).search("").draw()
    }
    function onlyArrived() {
        table.column(2).search(":").draw()
        table.column(3).search("").draw()
        table.column(4).search("").draw()
    }
    function onlyCommittee() {
        table.column(2).search("").draw()
        table.column(3).search("").draw()
        table.column(4).search("✓").draw()
    }

    function resetTable() {
        table.column(2).search("").draw()
        table.column(3).search("").draw()
        table.column(4).search("").draw()
    }
</script>
