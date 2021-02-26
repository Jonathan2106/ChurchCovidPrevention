<div class="container">
    <div class="row">
        <div class="col">
        <?php
            echo '<h2>'.$event_item['event_name'].' on-site registration</h2>';
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
        <?php echo form_open('events/onsite_reg/'.$event_item['event_id']); ?>
            <div class="form-group ">
                <label for="participant_name">Name</label><br>
                <input type="text" id="participant_name" name="participant_name" class="form-control" placeholder="Enter Your Name Here" required><br>
            </div>
            <div class="form-group">    
                <label for="participant_email">Email</label><br>
                <input type="email" id="participant_email" name="participant_email" class="form-control" placeholder="Enter Your Email Here" required>
                <p id="res">Please Enter your E-mail to Submit!</p><br>
            </div>
            <div>
            </div> 

            <input type="submit" id="submit" value="Register" class="btn btn-dark btn-block" disabled>

        </form>
        </div>
    </div>
</div>

<style>
    #res {
        font-size: 10pt;
        text-align: left;
        padding-left: 10px;
        color: #333333;
    }
</style>

<script>
    $(document).ready(function() {

        $("#participant_email").keyup(function(){

            var email = $("#participant_email").val();

            if(email != 0)
            {
                if(isValidEmailAddress(email))
                {
                    document.getElementById('res').innerHTML = 'E-mail is validated!';
                    document.getElementById('res').style.color = '#00cc00';
                    document.getElementById("submit").disabled = false;
                } else {
                    document.getElementById('res').innerHTML = 'E-mail is not validated!';
                    document.getElementById('res').style.color = '#cc0000';
                    document.getElementById("submit").disabled = true;
                }
            } else {
                document.getElementById('res').innerHTML = 'Please Enter your E-mail to Submit!';
                document.getElementById('res').style.color = '#333333';
                document.getElementById("submit").disabled = false;
            }

        });

    });

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }

</script>