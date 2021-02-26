<h2><?php echo $title; ?></h2>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css"/>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url("assets/js/jquery.redirect.js");?>"></script>

<style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style>

<br>
<div class="container">
    <form >
        <div class="form-group ">
            <div class="row">
                <div class="col">
                    <h3>Manual Input</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                <input type="text" id="participant_name" name="participant_name" class="form-control" placeholder="Participant Name" required><br>
                </div>
                
                <div class="col-md-4 col-sm-12">
                <input type="text" id="participant_email" name="participant_email" class="form-control" placeholder="Participant Email" required><br>
                </div>
                
                <div class="col-md-2 col-sm-12">
                <a href="#" class="btn btn-primary btn-block" onclick="add()">add</a><br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3>CSV file Input</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <input type="file" id="csv_input" name="csv_input" class="form-control-file"  placeholder="CSV Input" ></input><br>
                </div>

                <div class="col-md-4 col-sm-12">
                <a href="#" class="btn btn-primary btn-block" onclick="parse_csv()">process CSV</a><br>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <h3>Temporary List</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table id="participant_table" class="table table-striped table-bordered table-light table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Remove</th>
                    </tr>
                </thead>

                <tbody id="participant_list">
                <tbody>
            </table>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="#" class="btn btn-primary btn-block" onclick="submit_list()">Submit Temporary List</a><br>
        </div>
    </div>
</div>

<script>
    var t = $('#participant_table').DataTable();
    const Struct = (...keys) => ((...v) => keys.reduce((o, k, i) => {o[k] = v[i]; return o} , {}))  
    const People = Struct('name', 'email');
    var participant = [];

    $(document).ready(function() {
        $('#participant_table').DataTable();
    } );

    function display1(){
        document.getElementById("participant_list").innerHTML = "";
        
        if(participant.length == 0){
            document.getElementById("participant_list").innerHTML = "<tr><td colspan=3 align=\"center\">No Data</td></tr>"
        }
        for(i = 0; i< participant.length; i++){
            document.getElementById("participant_list").innerHTML += "<tr><td>" + participant[i].name + "</td><td>"+ participant[i].email + "</td><td><a href=\"#\" class=\"btn btn-primary\" onclick=\"remove("+i+")\">remove</a></td></tr>";
        }
    }

    function display(){
        //document.getElementById("participant_list").innerHTML = "";
        t.clear();

        if(participant.length == 0){
            t.row(t.data().length).remove().draw(false);
        }

        for(i = 0; i< participant.length; i++){
            //document.getElementById("participant_list").innerHTML += "<tr><td>" + participant[i].name + "</td><td>"+ participant[i].email + "</td><td><a href=\"#\" class=\"btn btn-primary\" onclick=\"remove("+i+")\">remove</a></td></tr>";
            t.row.add([
                participant[i].name,
                participant[i].email,
                "<a href=\"#\" class=\"btn btn-danger btn-block\" onclick=\"remove("+i+")\">remove</a></td></tr>"
            ]).draw( false );
        }
    }

    display();

    function add(){
        if(document.getElementById("participant_name").value != "" && document.getElementById("participant_email").value != ""){
            participant.push(People(document.getElementById("participant_name").value, document.getElementById("participant_email").value));
            document.getElementById("participant_name").value = "";
            document.getElementById("participant_email").value = "";
            display();
        }
    }

    function remove(num){
        participant.splice(num, 1);
        display();
    }

    function submit_list(){
        $.redirect('process_add', {participants: participant, event_id: <?php echo $events_item['event_id']; ?>});
    }

    var res = "";
    function parse_csv(){

        var file = document.getElementById("csv_input").files[0];
        console.log(file);
        var reader = new FileReader();
        reader.readAsText(file);
        reader.onload = function() {
            res = reader.result;
            console.log(res)

            console.log(res);
            var lines = res.split(/\r\n|\n|\r/);
            console.log(lines.length);
            console.log(lines);
            for(i = 1; i< lines.length-1; i++){
                console.log(lines[i]);
                var content = lines[i].split(",");
                console.log(content);
                participant.push(People(content[2]+' '+content[3], content[4]));
            }

            display()
        }
    }

    var input_name = document.getElementById("participant_name");
    input_name.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            add();
        }
    });

    var input_email = document.getElementById("participant_email");
    input_email.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            add();
        }
    });


</script>