<title>Thank You</title>

<script type='text/javascript'>
    $(document).ready(function () {
        $('#done').hide();
        var custreq = '<?php echo $_GET['id'] ?? '' ?>';
        $("#reqid").val(custreq);

        $("#consub").click(function () {
            var req = $("#reqid").val();
            $.ajax({
                url: "/RS/updateconf/",
                type: "POST",
                data: {
                    req: req
                },
                success: function (data) {
                    console.log('success');
                }
            });

            $("#reqconf").hide();
            $("#done").show();
        });
    });
</script>

<br/>

<div align="center">
    <div class="jumbotron text-xs-center">
        <h1 class="display-3">Thank You!</h1>
        <p id="done" class="lead"><strong>Your confirmation has been received.</strong></p>
        <div id="reqconf">
            <p class="lead"><strong>Please enter your request id to confirm.</strong></p>
            <br/>
            <b>Enter: </b><input type="text" id="reqid" />
            <button class="btn btn-success btn-sm" type="submit" id="consub"> Submit</button>
        </div>
        <hr>
        <p>
            Having trouble? <a href="https://www.stonegroup.co.uk/contact/">Contact us</a>
        </p>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="https://www.stonegroup.co.uk/" role="button">
                Continue to homepage
            </a>
        </p>
    </div>
</div>
