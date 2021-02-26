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

#canvas {
    position: absolute;
    top:0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: 0 auto auto auto;
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
    </div>
</div>
<hr>

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
    <div class="row justify-content-center mar-bot">
        <div class=".col-md-6 .col-sm-12">
            <canvas id="attandee_chart"></canvas>
        </div>
        <div class=".col-md-6 .col-sm-12">
            <canvas id="committee_chart"></canvas>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Attandee List</h2> 
        </div>
        <div class="col">
            <button type="button" class="btn btn-dark btn-block" onClick="expandList()" id ="attendee_button">Collapse</button>
        </div>
    </div>
</div>
<br>
<div class="container" id="attendee_list">
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
    </div>
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
    <br><br>
</div>


<!--
<div class="container">
    <div class="row">
        <div class="col">
            <?php
                    echo "Jemaat  ". $participant . "<br>";
                    echo "Jemaat Hadir  ".$attended_participant. "<br>";
                    echo ">30 min  ". $t30 . "<br>";
                    echo ">20 min  ". $t25 . "<br>";
                    echo ">18 min  ". $t18 . "<br>";
                    echo ">10 min  ". $t10 . "<br>";
                    echo ">5 min  ". $t5 . "<br>";
                    echo "onsite   ". $onsite . "<br>";
            ?>
        </div>
    </div>
</div><br>
!-->
<hr>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Arrival Chart</h2>
        </div>
    </div><br>
    <div class="row justify-content-md-center">
        <div class="col">
            <div style="width:100%;">
                <canvas id="arrival_chart"></canvas>
            </div>
        </div>
    </div>
</div>

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

    function expandList(){
        if(document.getElementById("attendee_button").innerHTML === "Expand"){
            document.getElementById("attendee_list").style.display = "block";
            document.getElementById("attendee_button").innerHTML = "Collapse";
        }else{
            document.getElementById("attendee_list").style.display = "none";
            document.getElementById("attendee_button").innerHTML = "Expand";
        }
    }

    $(document).ready(function() {
        expandList()
    });

    if (window.location.hash == "#onsite") {
        onlyOnsite();
    }

    var config_arrival = {
        type:    'line',
        data: {
            datasets: [
                {
                    label: "arrival",
                    data: [
                    <?php 
                        $gr_count = 0;
                        $first = TRUE;
                        $arrival = [];
                        foreach ($event_participant->result() as $row){
                            array_push($arrival, $row->participant_arrival);
                        }
                        sort($arrival);
                        foreach ($arrival as $row){
                            if ($row != NULL){
                                $timestamp = date('Y-m-d H:i:s',strtotime($row));
                                $gr_count++;
                                if( $first ) {
                                    echo "{ x: \"".$timestamp."\", y:".$gr_count."}";
                                    $first = FALSE;
                                } else echo ",{ x: \"".$timestamp."\", y:".$gr_count."}";
                            }
                        }
                    ?>
                    ],
                    fill:  false,
                    borderColor: 'black'
                }
            ]
        },
        options: {
            responsive: true,
            title:      {
                display: true,
                text:    "Arrival Chart"
            },
            scales:     {
                xAxes: [{
                    type:  "time",
                    time:  {
                        unit: 'hour',
                        displayFormats: {
                            hour: 'HH:mm'
                        }
                    },
                    scaleLabel: {
                        display:     true,
                        labelString: 'Date'
                    }
                }],
                yAxes: [{
                    scaleLabel: {   
                        display:     true,
                        labelString: 'value'
                    }
                }]
            }
        }
    };
    var config_attendee = {
        type: 'doughnut',
        data: {
            datasets: [{
                data:[
                    <?php
                        $slot1 = $participant-$attended_participant;
                        $slot2 = $attended_participant-$onsite;
                        echo $slot1.', '. $slot2 .','. $onsite;
                    ?>
                ],
                backgroundColor: [
                    'rgba(255, 255, 255, 0)',
                    'rgba(200, 200, 200, 1)',
                    'rgba(0, 0, 0, 1)',
                ],
                borderColor: [
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)',
                ],
                label: 'attandee'
            }],
            labels: [
					'not come',
					'registered',
					'onsite'
				]
        },
        options:  {
            responsive: true,
            legend: {
                position: 'top',
                align: 'end'
            }
        }
    };

    var config_committee = {
        type: 'doughnut',
        data: {
            datasets: [{
                data:[
                    <?php
                        $slot1 = $attended_participant-$committee;
                        $slot2 = $committee;
                        echo $slot1.', '. $slot2;
                    ?>
                ],
                backgroundColor: [
                    'rgba(230, 230, 230, 1)',
                    'rgba(0, 0, 0, 1)'
                ],
                borderColor: [
                    'rgba(0, 0, 0, 1)',
                    'rgba(0, 0, 0, 1)'
                ],
                label: 'attandee'
            }],
            labels: [
					'Jemaat',
					'Plelayan'
				]
        },
        options:  {
            responsive: true,
            legend: {
                position: 'top',
                align: 'end'
            }
        }
    };


    window.onload = function () {
        var ctx       = document.getElementById("arrival_chart").getContext("2d");
        window.myLine = new Chart(ctx, config_arrival);
        var ctx2      = document.getElementById("attandee_chart");
        window.myLine = new Chart(ctx2, config_attendee);
        var ctx3      = document.getElementById("committee_chart");
        window.myLine = new Chart(ctx3, config_committee);
    };
</script>
