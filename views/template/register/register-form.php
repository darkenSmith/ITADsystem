<?php
//@todo also need to handle failures.
?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#part2').hide();


        jQuery('#next').on('click', function () {
            password = jQuery('#password').val();
            username = jQuery('#username').val();
            email = jQuery('#username').val();
            companyname = jQuery('#companyname').val();
            compnum = jQuery('#compnum').val();
            comptype = jQuery('#comptype option:selected').val();
            firsname = jQuery('#firsname').val();
            lastname = jQuery('#lastname').val();
            telephone = jQuery('#lastname').val();

            if(companyname.length < 3 || firsname.length < 3 || lastname.length < 3 || telephone.length < 11 || telephone.length < 3){

                alert("please fill in form correctly");
            }else{
                             $('#part2').show();

            $('#part1').hide();
            }


         
        });
        jQuery('#reg').on('click', function () {
  
            redirect = "<?php echo $redirect; ?>";

            if (username.length < 3) {
                alert('Please enter your username');
                jQuery('#username').focus();
            } else if (password.length < 3) {
                alert('Please enter your password');
                jQuery('#password').focus();
            } else if (lastname.length < 3) {
                alert('Please enter your password');
                jQuery('#password').focus();
            }else if (firsname.length < 3) {
                alert('Please enter your password');
                jQuery('#password').focus();
            } else if (compnum.length < 3) {
                alert('Please enter your company number');
                jQuery('#password').focus();
            }  else if (companyname.length < 3) {
                alert('Please enter your company name');
                jQuery('#password').focus();
            }
            else {
                jQuery.ajax({
                    url: "/register/register",
                    type: "POST",
                   // data: "username=" + username + "&password=" + password + "&redirect=" + redirect,
                   data : {

                       username : username, 
                       firstname : firsname,
                       lastname : lastname, 
                       companyname : companyname,
                       email : email, 
                       password : password,
                       compnum :compnum, 
                       telephone : telephone,
                       comptype : comptype

                   },
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
<div class="row">
    <form class="form-register">
        <h2 class="form-signin-heading">Register Here</h2>
    
    <div id='part1'>
  <div class="form-group">
    <label for="companyname">Company Name</label>
    <input type="text" class="form-control" id="companyname" placeholder="Company Name">
</div>
<div class="form-group">
    <label for="firstname">First Name</label>
    <input type="text" class="form-control" id="firstname" placeholder="First Name">
    </div>
    <div class="form-group">
    <label for="lastname">Last Name</label>
    <input type="text" class="form-control" id="lastname" placeholder="Last Name">
</div>
<div class="form-group">
    <label for="telephone">Telephone</label>
    <input type="text" class="form-control" id="telephone" placeholder="Telephone">
</div>
<div class="form-group">
    <label for="Position">Position</label>
    <input type="text" class="form-control" id="Position" placeholder="Position">
    <div class="form-group">
  </div>
  <div class="form-group">
    <label for="comptype">My company is part of the...</label>
    <select class="form-control" id="comptype">
      <option value="CH">Private</option>
      <option value="URN">Public</option>
    </select>
  </div>
  <div class="form-group">
    <label for="compnum">Company Number</label>
    <input type="text" class="form-control" id="compnum" placeholder="Company Number">
  </div> 
  <a  id='next' class='btn btn-success'>Next </a>
  </div>
  </div>

  <div id='part2'>
  <div class="form-group">
    <label for="username">Email Address</label>
    <input type="email" class="form-control" id="username" placeholder="enter email here">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" placeholder="password">
  </div>
  <button class="btn btn-lg btn-primary btn-block" id="reg">Submit</button>


</div>
  
  
</form>
</div>

