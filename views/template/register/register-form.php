<?php
//@todo also need to handle failures.
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
                    url: "/register/register",
                    type: "POST",
                    data: "username=" + username + "&password=" + password + "&redirect=" + redirect,
                    success: function (data) {
                        if (data == 1) {
                            document.location = '<?php echo $redirect; ?>'
                        } else {
                            alert(data)
                        }
                    }
                });
            }
        });
    });

</script>


<h2>REGISTER FORM</h2>

