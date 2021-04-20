<script type="text/javascript">
    jQuery(document).ready(function () {
        let comp = [];
        let step2_available = false;

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
            } else if (comptype == 'CH') {
                jQuery.ajax({
                    url: "/register/checkCompany",
                    type: "POST",
                    dataType: "json",
                    data: {
                        companyname: companyname,
                        compnum: compnum
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.company.process) {
                            var comp = data.company.companies.items;

                            if (comp.length > 0) {
                                $.each(comp, function (index, value) {
                                    console.log(index + ' : ' + value.title);
                                    $("#compselect").append("<option value='" + value.company_number + "'>" + value.title + "</option>");
                                    $("#compselect").show();
                                });
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                            } else {
                                step2_available = true;
                            }

                        } else {
                            step2_available = false;
                        }
                    }
                });
            } else {
                step2_available = true;
            }

            step2Pass(step2_available);
        });


        function step2Pass(available) {
            if (available) {
                $('#part2').show();
                $('#part1').hide();
                $('.step-title').html('(Step 2)');
            } else {
                $('#part2').hide();
                $('#part1').show();
                $('.step-title').html('(Step 1)');
            }
        }

        $('#compselect').bind("change keyup",function() {
            if ($("#compselect option:selected").text() != 'Please select match.' || index.length == 0) {
                jQuery('#companyname').val($("#compselect option:selected").text());
                jQuery('#compnum').val($("#compselect option:selected").val());
                step2Pass(true);
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
            } else if (!passwordcheck.test(password)) {
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
                    dataType: "json",
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
                        position: position
                    },
                    success: function (data) {
                        //console.log(data);
                        if (data.success) {
                            $('#part1').hide();
                            $('#part2').hide();
                            $('#errorContainer').html(data.message);
                            //console.log(data.message);
                            setTimeout(function () {
                                window.location = redirect; 
                            }, 2000);
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
    <h2 class="form-signin-heading"><?= _REGISTER ?></h2>

    <div id="errorContainer"></div>
    <form name='registration' method="">
        <div id='part1'>
            <div class="form-group">
                <label for="companyname"><?= _COMPANY ?></label>
                <input type="text" minlength="3" class="form-control" id="companyname" placeholder="Company Name"
                >
                <div id="company_list">

                    <select id='compselect'>
                        <option><?= _PLEASE ?></option>
                        


                    </select>

                </div>
            </div>
            <div class="form-group">
<<<<<<< HEAD
                <label for="firstname"><?= _FNAME ?></label>
                <input type="text" minlength="3"  class="form-control" id="firstname" placeholder="First Name"
                       >
            </div>
            <div class="form-group">
                <label for="lastname"><?= _LNAME ?></label>
                <input type="text" minlength="3"  class="form-control" id="lastname" placeholder="Last Name"
                       >
            </div>
            <div class="form-group">
                <label for="telephone"><?= _TELE ?></label>
                <input type="text" minlength="10"  class="form-control" id="telephone" placeholder="Telephone"
                       >

            </div>
            <div class="form-group">
                <label for="Position"><?= _POSITION ?></label>
                <input type="text" minlength="3" class="form-control" id="Position" placeholder="Position"
                >
                <div class="form-group">
                </div>
                <div class="form-group">
                    <label for="comptype"><?= _COMPTYPETXT ?></label>
                    <select class="form-control" id="comptype">
                        <option value="CH"><?= _PRIVATECOMP ?></option>
                        <option value="URN"><?= _PUBLICCOMP ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="compnum"><?= _COMPANYNUM ?></label>
                    <input type="text" class="form-control" id="compnum" placeholder="Company Number"
                           minlength="6" maxlength="9">
                </div>
<<<<<<< HEAD
                <button id='next' class='btn btn-success'><?= _NEXT ?> </button>
=======
                <button id='next' class='btn btn-success'>Next</button>
>>>>>>> edbed6e7355b3c8e904ab456a1453d9229c3366d
            </div>
        </div>

        <div id='part2'>
            <div class="form-group">
                <label for="username"><?= _EMAILADD ?></label>
                <input type="email" class="form-control" id="username" placeholder="enter email here">
            </div>
            <div class="form-group">
                <label for="password"><?= _PASSWORDTXT ?></label>
                <input type="password" class="form-control" id="password" placeholder="password">
            </div>
            <button class="btn btn-lg btn-primary btn-block" id="reg"><?= _SUBMIT ?></button>
        </div>
    </form>
</div>