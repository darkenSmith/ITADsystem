<script type="text/javascript">
    jQuery(document).ready(function () {
        var comp = [];


        $("#compselect").hide();
        $("#part2").hide();
        let password, username, email, companyname, compnum, comptype, firstname, lastname, telephone, position;
        jQuery('#next').on('click', function (e) {
            e.preventDefault();
            password = jQuery('#password').val();
            username = jQuery('#username').val();
            email = username;
            companyname = jQuery('#companyname').val();
            compnum = jQuery('#compnum').val();
            comptype = jQuery('#comptype option:selected').val();
            firstname = jQuery('#firstname').val();
            lastname = jQuery('#lastname').val();
            telephone = jQuery('#telephone').val();
            position = jQuery('#Position').val();
 

                if (
                    (undefined !== companyname && companyname.length < 3) ||
                    (undefined !== compnum && compnum.length < 6 && compnum.length > 9) ||
                    (undefined !== firstname && firstname.length < 3) ||
                    (undefined !== lastname && lastname.length < 3) ||
                    (undefined !== telephone && telephone.length < 11)
                ) {
                    alert("please fill in form correctly");
                } else if(comptype == 'CH'){

                    jQuery.ajax({
                        url: "/register/checkCompany",
                        type: "POST",
                        dataType : "json",
                        data: {
                            companyname: companyname,
                            compnum: compnum
                        },
                        success: function (data) {
                            console.log(data);
                            if(data.company.process) {

                              
                               var comp = data.company.companies.items;

                               if(comp.length > 0){

                               
                               $.each(comp, function (index, value) {
                                        console.log(index+' : '+value.title);

                                $("#compselect").append("<option value='"+value.company_number+"'>"+value.title+"</option>");
                                $("#compselect").show();
                                $('#compselect').change(function(){
                                    if($("#compselect option:selected").text() != 'Please select match.' || index.length == 0) {
                                        jQuery('#companyname').val($("#compselect option:selected").text());
                                        jQuery('#compnum').val($("#compselect option:selected").val());
                                        // $('#part2').show();
                                        // $('#part1').hide();
                                    }else{
                                        alert("False");
                                    }
                                });

                             });
                        }else{
                            alert("stop");
                            $('#part2').show();
                            $('#part1').hide();
                        }
                                    // alert(1);
  
                               }else {
                            alert(2);
                            }
                        }
                    });
                }else{
                   
                    $('#part2').show();
                    $('#part1').hide();
                }
        });

        jQuery('#reg').on('click', function (e) {
            e.preventDefault();
            password = jQuery('#password').val();
            username = jQuery('#username').val();
            let redirect = "<?php echo $redirect; ?>";

            let passwordcheck = new RegExp(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}/);
            let passwordcheck2 = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]$/;


            if (username.length < 3) {
                alert('Please enter your username');
                jQuery('#username').focus();
            }else if (!passwordcheck.test(password)) {
                alert('Minimum eight characters, at least one letter, one number and one special character:');
                jQuery('#password').focus();
            } else if (lastname.length < 3) {
                alert('Please enter your password');
                jQuery('#password').focus();
            } else if (firstname.length < 3) {
                alert('Please enter your password');
                jQuery('#password').focus();
            } else if (compnum.length < 3) {
                alert('Please enter your company number');
                jQuery('#password').focus();
            } else if (companyname.length < 3) {
                alert('Please enter your company name');
                jQuery('#password').focus();
            } else {
                jQuery.ajax({
                    url: "/register/register",
                    type: "POST",
                    dataType : "json",
                    data: {
                        username: username,
                        firstname: firstname,
                        lastname: lastname,
                        companyname: companyname,
                        email: username,
                        password: password,
                        compnum: compnum,
                        telephone: telephone,
                        comptype: comptype,
                        position : position
                    },
                    success: function (data) {
                        //console.log(data);
                        if (data.success) {
                            $('#part1').hide();
                            $('#part2').hide();
                            $('#errorContainer').html(data.message);
                            //console.log(data.message);
                            setTimeout(function(){ window.location = redirect; }, 2000);
                        } else {
                            $('#errorContainer').html(data.message);
                        }
                    }
                });
            }
        });
    });
</script>

<div class="row">
    <h2 class="form-signin-heading">Register Here</h2>
    <div id="errorContainer"></div>
    <form name='registration' method="">
        <div id='part1'>
            <div class="form-group">
                <label for="companyname">Company Name</label>
                <input type="text" minlength="3" class="form-control" id="companyname" placeholder="Company Name"
                       >
                <div id="company_list">
                    <select id='compselect'>
                        <option> Please select match. </option>
                        

                    </select>

                </div>
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" minlength="3"  class="form-control" id="firstname" placeholder="First Name"
                       >
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" minlength="3"  class="form-control" id="lastname" placeholder="Last Name"
                       >
            </div>
            <div class="form-group">
                <label for="telephone">Telephone</label>
                <input type="text" minlength="10"  class="form-control" id="telephone" placeholder="Telephone"
                       >
            </div>
            <div class="form-group">
                <label for="Position">Position</label>
                <input type="text" minlength="3" class="form-control" id="Position" placeholder="Position"
                >
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
                    <input type="text" class="form-control" id="compnum" placeholder="Company Number"
                           minlength="6" maxlength="9">
                </div>
                <button id='next' class='btn btn-success'>Next </button>
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