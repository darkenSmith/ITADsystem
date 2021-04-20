<?php
//@todo also need to handle failures.

echo $_SESSION['lang'];


if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   

// Append the requested resource location to the URL   
$url.= $_SERVER['REQUEST_URI'];    

echo $_SERVER['REQUEST_URI'];  
    
?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#login').on('click', function () {
            password = jQuery('#password').val();
            username = jQuery('#username').val();
            redirect = "<?php echo $redirect; ?>";

            if (username.length < 3) {
                alert('Please enter your username');
                jQuery('#username').focus();
            } else if (password.length < 3) {
                alert('Please enter your password');
                jQuery('#password').focus();
            } else {
                jQuery.ajax({
                    url: "/login/ajax",
                    type: "POST",
                    data: "username=" + username + "&password=" + password + "&redirect=" + redirect,
                    success: function (data) {
                        if (data == 1) {
                            document.location = '<?php echo $redirect; ?>';
                        } else {
                            alert(data);
                        }
                    }
                });
            }
        });

        jQuery('#sendReminder').on('click', function () {
            var email = jQuery('#email').val();
            if (email) {
                jQuery.ajax({
                    type: 'POST',
                    url: '/login/forgot',
                    data: {
                        email: email
                    },
                    success: function (data) {
                        jQuery('#result').show();
                        jQuery('#forgotModal').modal('hide');
                        jQuery('#result').html(data);

                    }
                });
            }
        });

        $('#lang').on('change',function(e) {
    switch($(this).val()) {
        case 'en':
            window.location = '/?lang='+$(this).val();
        break;
        case 'fr':
            window.location = '/?lang='+$(this).val();
        break;
    }
});
    });

</script>
<!-- Modal -->
<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="forgotOverlay">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= _RESTARTXT ?></h4>
            </div>
            <div class="modal-body">
                <form class="form" id="addressForm">
                    <div class="form-group">
                        <label for="email"><?= _EMAIL ?></label>
                        <input type="text" class="form-control" id="email" name="email" value=""/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= _CLOSETEXT ?></button>
                <button type="button" id="sendReminder" class="btn btn-success"><?= _RESTARTXT ?></button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <form class="form-signin">
    <select id='lang'>
    <option value=""><?php echo strtoupper($_SESSION['lang']);?></option>
                        <option value="en">EN</option>
                        <option value="fr">FR</option>
                        </select>
        <h2 class="form-signin-heading"><?= _SIGN ?></h2>
        <div id="result" style="display: none"></div>
        <label for="username" class="sr-only"><?= _EMAIL ?></label>
        <input type="email" id="username" class="form-control" placeholder="Enter your Email address" required
               autofocus>
        <label for="password" class="sr-only"><?= _PASSWORD ?></label>
        <input type="password" id="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" id="login"><?= _SIGNIN ?></button>
        <a class="btn btn-sm btn-link" id="forgot" data-toggle="modal" data-target="#forgotModal"><?= _FORGOT ?></a>
        <a href="/register" class="btn btn-sm btn-link pull-right" ><?= _REGISTER ?></a>
    </form>
</div>
