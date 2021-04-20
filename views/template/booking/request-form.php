<style>


    th {

        font-size: 1.5em;

    }


    td {

        font-size: 1.4em;

    }

    .glyphicon {
        font-size: 25px;
    }

    /* stone agreement box  */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 0; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .con {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 60%; /* Could be more or less, depending on screen size */
        margin-top: 120px;
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }


    .plus .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        font-size: 1em;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }

    .plus:hover .tooltiptext {
        visibility: visible;
    }


    .delline .tooltiptext2 {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        font-size: 1em;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }

    .delline:hover .tooltiptext2 {
        visibility: visible;
    }

    .form-header {

        /*background-color:black;*/
        background: url("/assets/media/recyclingform_headerimg.jpg") no-repeat;
        background-size: 100%;
        margin: 0;
        border-bottom: 10px solid black;

        color: white;
        text-align: center;
        padding: 4em;
    }

    .form-header h1 {
        font-size: 5em;
        color: white;
        text-decoration: underline;
    }

    .booking-form h3 {
        font-size: 2em;
    }

    #space {
        padding: 20px;
    }


    #part option {
        font-weight: bold;
    }


    #pdf p {
        font-size: 3em;
    }


</style>
<?php echo $_SERVER['HTTP_REFERER']; ?>
<h1><?= _BOOKTITLE ?></h1>

<div class='form-header container-fluid'>

    <h1><?= _ITADTXT ?></h1><br>
    <!-----<h3>Book a Collection</h3><br>--->
    <img src='/assets/media/StoneLogo.png' alt='Stone' height='70'/>

    <br>
    <br>
</div>


<div class="container-fluid booking-form">
    <br>
    <br>


    <div class="row">


        <form id="formstuff" method="POST" action="/booking/update" enctype="multipart/form-data">
            <div class="form-group ">
                <div class="col-xL-4">
                    <label for="org"> <?= _ORGTXT ?><span style="color:red;">*</span></label>

                    <input type="text" id="org" name="Org" maxlength="200" class="form-control"
                           placeholder="<?= _ORGNAME ?>"/><br>


                    <label for="reqcon"> <?= _CONTACTXT ?> </label>
                    <input type="text" id="reqcon" maxlength="100" class="form-control"
                           placeholder=" <?= _CONTACTXT ?>"><br>

                    <label> <?= _POSITION ?> </label>
                    <input type="text" id="pos" maxlength="100" name="position" class="form-control"
                           placeholder="<?= _POSITION ?>"><br><br>


                    <label for="email"> <?= _EMAILADD ?><span style="color:red;">*</span></label>
                    <input type="email" name="contactemail" maxlength="100" id="email" class="form-control "
                           placeholder="<?= _EMAIL ?>"/><br><br>

                    <label> <?=_TELE?><span style="color:red;">*</span></label>
                    <input type="text" id="tel" maxlength="20" class="form-control"/>
                    <br>

                    <label for="country"> <?= _COUNTY ?><span style="color:red;">*</span></label>
                    <div class="dropdown">
                        <select class="form-control" id="country">
                            <option value="de" selected><?= _SELCOUNTY ?></option>
                            <option value="England"><?= _ENG ?></option>
                            <option value="Wales"><?= _WLE ?></option>
                            <option value="Scotland"><?= _SCT?></option>
                            <option value="Other"><?=_OTH ?></option>


                        </select>
                    </div>

                    <div id='premisestuff'>
                        <label for="prem" style="color: #FF0000"> <?= _PREM?> </label>
                        <input type="text" maxlength="20" name="premisescode" id="prem" class="form-control"/><br>
                        <span style="font-size:12.0pt;line-height:115%; font-family: Calibri;">
                          <?= _PREMNOTE ?>
                            <br>
                            <?= _CLICK ?> <a href="http://www.environment-agency.gov.uk/business/topics/waste/32198.aspx"
                                     target="_blank" style="color: #008000"><?=_HERE ?></a> <?=_HERETXT ?>
                        </span>
                        <br>
                        <span> <label><?= _EXEMPT ?></label></span> <input type="checkbox" name="ex" id="expmt"> <br><br>
                    </div>


                    <br>


                    <br>

                </div>
                <div class="row">
                    <div>
                        <label> <?= _ADDRESS ?><span style="color:red;">*</span></label><br>
                        <input type="text" id="add1" maxlength="50" name="Address1" class="form-control"
                               placeholder="<?=_ADD1 ?>"><Br>
                        <input type="text" id="add2" maxlength="50" class="form-control"
                               placeholder="<?=_ADD2 ?>"><br>
                        <input type="text" id="add3" maxlength="50" class="form-control"
                               placeholder="<?=_ADD3 ?>"><br>
                        <label> <?=_TOWN ?><span style="color:red;">*</span></label><br> <input type="text" maxlength="50"
                                                                                         class="form-control" id="twn"
                                                                                         placeholder="<?=_TOWN ?>"><br>
                        <label> <?=_POSTCODE?><span style="color:red;">*</span></label><br> <input type="text" maxlength="8"
                                                                                             name="Postcode"
                                                                                             class="form-control"
                                                                                             id="postc"
                                                                                             placeholder="<?=_POSTCODE?>"/>
                        <br>
                        <label><?=_SITECON ?> </label>
                        <input type="text" maxlength="20" id="cont" name="SiteContact" class="form-control"
                               placeholder="<?=_SITECONPLACE?>"><br>

                        <label> <?=_SITEPHONE ?></label>
                        <input type="text" maxlength="20" id="contph" name="contactphone" class="form-control"
                               placeholder="<?=_SITEPHONE?>" > <br>


                        <br>


                        <h3><?= _COLDETITLE ?></h3>
                        <p><?= _COLNOTE1 ?></p>
                        <br>

                        <strong><?= _COLLCRGE ?></strong>
                        <p><?= _COLNOTE2 ?> </p>


                        <br>
                        <p><b><?= _COLUNITNOTE ?></b></p>


                        <table class="table" id="tb">
                            <thead>
                            <tr class="tr-header">

                                <th> <?= _ITEMS ?></th>
                                <th> <?=  _QTY ?></th>
                                <th hidden><?=_AMR ?></th>


                                <th hidden class="plus"><a href="javascript:void(0);" style="font-size:18px;"
                                                           id="addMore" title="<?= _ADDMORELINE ?>"><span
                                                class="glyphicon glyphicon-plus"></span></a>
                                    <span class="tooltiptext"><?= _ADDLINENOTE ?></span></th>


                            </thead>

                            <tbody>
                            <tr id="row0">
                                <td>

                                    <div class="control-group">
                                        <div class="dropdown">
                                            <select name="select-parts" id='part' class="form-control select-parts">
                                                <option value="de" selected><?= _SELECTPART ?></option>
                                                <option value="3"><?=_PCI ?></option>
                                                <option value="71"><?= _PCA ?></option>
                                                <option value="53"><?=_PCAMD ?></option>
                                                <option value="55"><?=_PCAMD ?></option>
                                                <option value="31"><?= _AIOI ?></option>
                                                <option value="75"><?=_AIOA?></option>
                                                <option value="63"><?=_AIOAMD?></option>
                                                <option value="61">ALLINONE <?=_PCUNK?></option>
                                                <option value="5"><?=_LAPI?></option>
                                                <option value="73"><?=_LAPA?></option>
                                                <option value="59"><?=_LAPAMD?></option>
                                                <option value="57"><?=_LAPUN?></option>
                                                <option value="47"><?=_SMRTPHNE?></option>
                                                <option value="45"><?=_APPPHNE?></option>
                                                <option value='33'><?=_NONPHNE?></option>
                                                <option value="51"><?=_TAB?></option>
                                                <option value="11">TFT Monitors</option>
                                                <option value="49"><?=_APPTAB?></option>
                                                <option value="15"><?=_TV?></option>
                                                <option value="7"><?=_SERVER?></option>
                                                <option value="43"><?=_NETWRK?></option>
                                                <option value="17"><?=_HRDDRIVE?></option>
                                                <option value="29"><?=_SMRTBOARD?></option>
                                                <option value="9"><?=_PROJ?></option>
                                                <option value="25"><?=_DESK?></option>
                                                <option value="27"><?=_STANDPRI?></option>
                                                <option value="41"><?=_LAPTRO?></option>


                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td id="errparts" hidden><p style="color:red;"> </p></td>
                                <td><input type='number' min="0" max="5000" class='working'></td>
                                <td hidden><input type='number' min="0" max="5000" class='notworking'></td>
                                <td hidden><input type='checkbox' class='v'></td>
                                <td hidden><input type='checkbox' class='w' name='wipe'></td>
                                <td class="delline" hidden><a href='javascript:void(0);' class='remove'><span
                                                class='glyphicon glyphicon-remove'></span></a>
                                    <span class="tooltiptext2"><?= _REMOVELINE ?></span></td>

                            </tr>
                            </tbody>
                        </table>
                        <p id='applenote'><label><?= _NOTETAG ?></label><?= _NOTETAGTXT ?>
                            collection <a href='STONEiphonedoc.pdf' target="_blank"> <?= _CLICKHERE ?> </a> <?= _GUIDE ?> </p>
                        <p id='charge' style='color:red;'> <?= _ITEMTXT ?> </p>

                        <input type='button' value='Add Line' class="btn btn-primary btn-lg" id='addmore2'>
                        <br>
                        <br>
                        <strong><?= _ADDTIMES ?></strong>
                        <p> <?= _PRODUCTTXT ?></p><br>
                        <!-- <p>(e.g. peripherals x 2, Tapes x 10 and total in the Quantity box)</p> -->
                        <p>
                        <p id="limit"><b>3</b></p>
                        <input type="text" maxlength="100" id="newitem" placeholder="<?= _EG2 ?>"><label><input
                                    type="button" class="btn btn-primary btn-lg" id="additem" value="<?= _SUBMIT ?>"></label>
                        <br>
                        <br>
                        <br>

                        <div id="imgupload">

                            <p style="color:green;"><strong> <?= _PLEASEPRO ?></strong></p>
                            <p style="color:green;"><strong> <?= _8MBTXT ?></strong></p><br>
                            <div>
                                <input type="file" id="file" name="inputfile[]" accept=".jpeg,.jpg,.png, .gif"
                                       data-type='image'/><span style="color:red;">*</span>
                                <input type="file" id="file1" name="inputfile[]" accept=".jpeg,.jpg,.png, .gif"
                                       data-type='image'/>
                                <input type="file" id="file2" name="inputfile[]" accept=".jpeg,.jpg,.png, .gif"
                                       data-type='image'/>
                                <input type="file" id="file3" name="inputfile[]" accept=".jpeg,.jpg,.png, .gif"
                                       data-type='image'/>
                                <input type="file" id="file4" name="inputfile[]" accept=".jpeg,.jpg,.png, .gif"
                                       data-type='image'/>
                            </div>

                        </div>
                        <p id='errpic' style="color:red;"><?= _CHECKFILE ?></p>
                        <br>
                        <br>


                        <br>
                        <label> <?= _NATXT ?></label>
                        <input type="text" maxlength="255" class="form-control" id="biopass"
                               placeholder="<?= _BIOPL ?>">
                        <strong><?= _NAPLACE ?> </strong>
                        <input type="checkbox" id="bioscheck"/><br>

                        <br>
                        <hr>

                        <div class="col-xl-4">
                            <p><label><?= _NOTETAG ?> </label> <?= _OURCOLL ?> </p>
                            <br><br>

                            <div class="avalidays">
                            <table class="tabledays">
                            <thead>
                            <tr>
                            <th> <?= _AVADAYS ?> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                            <td>  <input type="checkbox" id="mond" name="days" value="Monday"> <?= _MON ?><td>
                            <td>  <input type="checkbox" id="tues" name="days" value="Tuesday"> <?= _TUE ?><td>
                            </tr>
                            <tr>
                            <td>  <input type="checkbox" id="wens" name="days" value="Wensday"> <?= _WED ?><td>
                            <td>  <input type="checkbox" id="thrus" name="days" value="Thursday"> <?= _THURS ?><td>
                            
                            </tr>
                            <tr>
                            </tr>
                            <td>  <input type="checkbox" id="frid" name="days" value="Friday"> <?= _FRI ?><td>
                            </tr>
                            
                            </table>
                            </tbody>
                            </div>



                            <br>
                            <label><?= _EARLY ?></label>

                            <select class="eaccess form-control" id="early">
                                <option selected disabled style="color:grey;"><?= _SELECTOPTION ?></option>
                                <?php

                                for ($hours = 0; $hours < 24; $hours++) // the interval for hours is '1'
                                    for ($mins = 0; $mins < 60; $mins += 30) // the interval for mins is '30'
                                        echo '<option>' . str_pad($hours, 2, '0', STR_PAD_LEFT) . ':'
                                            . str_pad($mins, 2, '0', STR_PAD_LEFT) . '</option>';


                                ?>
                            </select>
                        </div>
                        <br>
                        <div class="col-xl-4">
                            <label> <?= _TIMEAVIOD ?> </label>
                            <textarea rows="4" cols="50" class="avoidcas form-control" id="avoid"></textarea>
                        </div>
                        <div class="col-xl-4">
                            <label> <?=_FURTHERINFO ?></label>
                            <textarea rows="4" cols="50" class="avoidissuecl form-control" id="avoidissue"
                                      placeholder=" <?=EGINFO1?>  "></textarea>
                        </div>
                        <br>
                    </div>
                    <br>
                    <br>
                    <hr>
                    <p class='font-italic'><label><?= _NOTETAG ?> </label> <?= _GROUNDWARN ?> </p>
                    <br>
                    <div class="ground col-xl-4">

                        <label> <?= _ISGROUND ?></label>
                        <select class="form-control" style="padding-right:20px;">
                            <option selected disabled style="color:grey;"><?= _SELECTOPTION ?></option>
                            <option value='Yes'>Yes</option>
                            <option value='No'>No</option>
                        </select>
                    </div>
                    <br>
                    <div class="lift col-xl-4">
                        <label> <?= _LIFT?></label>
                        <select id="liff" class="lif<?=_TV?>al form-control" style="padding-right:20px;">
                            <option disabled style="color:grey;"><?= _SELECTOPTION ?></option>
                            <option value='Yes'><?= _YES ?></option>
                            <option value='No'><?= _NO ?></option> 
                        </select>
                    </div>
                    <br>
                    <div class="steps col-xl-4">
                        <label><?= _STEPS?></label>
                        <select class="stepsval form-control" style="padding-right:20px;">
                            <option selected disabled style="color:grey;"><?= _SELECTOPTION ?></option>
                            <option><?= _YES ?></option>
                            <option><?= _NO ?></option>
                        </select>
                    </div>

                    <br>


                    <div class="park col-xl-4">
                        <label>Please give details of collection parking</label>
                        <select class="parking form-control">
                            <option selected disabled style="color:grey;"><?= _SELECTDESC ?></option>
                            <option><?= _ALLOCATED?></option>
                            <option><?= _PLENTY?></option>
                            <option><?= _ONSTREET?></option>
                            <option><?= _PD?></option>
                            <option><?= _BAY?></option>
                        </select>
                    </div>
                    <br>
                    <div class="col-xl-4">
                        <label><?= _BULK ?></label>
                        <select class="twoman form-control" style="padding-right:20px;">
                            <option selected disabled style="color:grey;"><?= _SELECTOPTION ?></option>
                            <option><?= _YES ?></option>
                            <option><?= _NO ?></option>
                        </select>
                    </div>
                    <br>
                    <div class="help col-xl-4">
                        <label>Is there help on site?</label>
                        <select class="onsite form-control" style="padding-right:20px;">
                            <option selected disabled style="color:grey;"><?= _SELECTOPTION ?></option>
                            <option value="Yes"><?= _YES ?></option>
                            <option value="No"><?= _NO ?></option>
                        </select>

                    </div>
                </div>

                <br>

                <div id="confarea">
                    <br>
                    <strong>Data Protection Law</strong>
                    <br><?=_DATALAW1?>
                    <p> <?=_DATALAW2 ?>
                        <input type="checkbox" id="confirmed" value="ON"></p>
                </div>


                <hr>
                <input type="submit" class="btn btn-primary btn-lg" id="testbutt">

                <br>
                <br>
                <p id='er' style="color:red;"> <?=_SCROLLUP?> </p>


            </div>

            <strong><?= _PLEASECON ?> <br><br><?= _EMAILFORM ?>
                <a href="mailto:Tracey.Melbourne@stonegroup.co.uk" style="color: #008000">Tracey.Melbourne@stonegroup.co.uk </a><br>
                Direct Telephone Number:<?= ITADNUM ?></strong>
            <br>
        </form>
    </div>
    <div id="myModal" class="modal">
        <div align="center" class='con'>
            <span class="close">&times;</span>
            <h1 class="display-3"><?=_STANDARD ?></h1><br>
            <div id="pdf">
                <iframe src="/assets/doc/ITAD_terms.pdf" width=70% height=600>
                    <a href="/assets/doc/#/OnlineDataProcessingContract.pdf"><?= _DOWNLOAD ?></a></iframe>
                <br><br></div>

            <button type="button" id="agree" class="btn btn-success"><b><?= _AGREE ?></b></button>
            <button type="button" id="disagree" class="btn btn-danger"><b><?= _AGREE ?></b></button>
            <br>
            <br>

            <hr>
            <h2> <?= _BESPOKEAGREE ?> </h2>
            <p> <?= _BESPOKETXT ?> <a href="mailto:Tracey.Melbourne@stonegroup.co.uk?Subject=GDPR%20Enquires"><?= _EMAILUS ?></a> <?= _CALLUS ?> <a href="01785786775"><?= ITADNUM ?></a>.<br><br>
            <p class="lead"><a class="btn btn-primary btn-sm" href="https://www.stonegroup.co.uk/" role="button"><?=_HOMEPAGE ?></a></p>
        </div>
    </div>


    <div id="space">

    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        val = 17;
        var count = 3;
        var othercount = 0;
        var is_exempt = 0;
        var newline;
        var newline2;
        var pre = [];
        var assettick = 0;
        var wipetick = 0;
        var f_assettick = 0;
        var f_wipetick = 0;
        var check = 0;
        var chargable = 0;
        var avalidays = [];
        var other1del = 0;
        var other2del = 0;
        var other3del = 0;
        var uploadcomp = 1;


        var id = 0;
        var i = 0;
        var addlimit = 0;

        var jsonsuperclean = '';
        var cur = '';
        var curname = '';
        var othercheck = 0;
        var filecheck = 0;
        var daystring = "";
        var daysavaliable ="";

        var lift = $('.lift option:selected').text();
        var steps = $('.steps option:selected').text();
        var parking = $('.parking option:selected').text();
        var twoman = $('.twoman option:selected').text();
        $('#errpic').hide();
        $('#er').hide();
        
        var errcount = 0;
//showsize();
        $('#applenote').hide();


        $('.lift').hide();


        $('#limit').html("<p><b><?=_ENTRYLEFT?>:</b> 3</p>");

        $('#myModal').css("display", "none");

        $('.close').on('click', function () {
            $('#myModal').css("display", "none");

        });


        $('#disagree').on('click', function () {

            if (filecheck == 0) {
                deluploadimage();

            }

           
            $.MessageBox("<?php echo _AGREEERR ?> ");
            $('#myModal').css("display", "none");

        });

        $('#agree').on('click', function () {
            check = 1;


            $('#testbutt').click();


        });

        $('.ground').on('change', function () {


            var selected = $(".ground option:selected").val();
            console.log(selected);

            if ($(".ground option:selected").val() == 'No') {
                $('.lift select').val('Please Select a option..');
                $('.lift').show();
            } else if ($(".ground option:selected").val() == 'Yes') {
                lift = $('.lift option:selected').val('')
                $('.lift').hide();
                console.log(lift);


            } else {
                $('.lift').hide();
            }

        });


        $('#premisestuff').hide();


        var arr = [];
        var newArray = [];
        var thepast = [];
        var history = [];


        var selpoint = '';


        $('input[type=file]').on('change', function () {
            // $('input[type=file]').each(function(i, value)

            console.log((this.files[0].size / 1024 / 1024).toFixed(2));
            var size = (this.files[0].size / 1024 / 1024).toFixed(2);
            if (size > 8.0) {
                $(this).val('');
                $('#errpic').text('Check file size..');
                $('#errpic').show();
            }

        });


// $('select[name=team2]').on('change', function() {
//   console.log('select');

// // $('#tb tr').each(function() {

// // idd = $(this).closest('tr').attr('id');

// // console.log(idd);

// //    var self = $('#row0 select[name=select-parts]').val();
// // console.log(self);
// // $('#row1 select[name=select-parts]').find('option').prop('disabled', function() {
// // console.log(this.value);
// // return this.value == self
// // });

// // if(id > 1){


// // }

// //     });

// });


// if(id > 0){

//  $.MessageBox('yes more than 0');

//    var self = $('#row1 select[name=select-parts]').val();
//     console.log(self);
//  $('#row0 select[name=select-parts]').find('option').prop('disabled', function() {
//    console.log(this.value);
//      return this.value == self
//    });


// }


// if(cur.length){

// $('.select-parts').on('click', function() {
// if(cur !== partselected){
//    $.MessageBox(cur);
//    $.MessageBox(curname);
//   $('#tb #row'+id+'').find('.select-parts').append("<option value="+cur+">"+curname+"</option>");

// // });

// }


//}#
        $(" .working").prop('disabled', true);
//$(" .notworking").prop('disabled', true);


        $('.select-parts').on('change', function () {


            if ($('.select-parts').val() !== 'de') {


                $(" .working").prop('disabled', false);
                // $(" .notworking").prop('disabled', false);

            }


        });

//6$('input[type=file]').on('change',showsize());


        $('#tb').on('input', 'tbody tr', function (event) {


            totalqty = 0;

            $('#tb tr').each(function () {


                var working = Number($(this).find(".working").val());
                var selected = $(this).find(".select-parts option:selected").html();


                var selectedop = $(this).find(".select-parts option[value='19']").html();

                console.log(selectedop + ':test');


                if (selected == '<?=_PCA?>' || selected == '<?=_AIOA?>' || selected == '<?=_LAPA?>' || selected == '<?=_APPPHNE?>' || selected == '<?=_APPTAB?>') {

                    $('#applenote').show();
                } else {
                    //$('#applenote').hide();
                }


                if (working !== undefined) {
                    if (selected == '<?=_PCI?>' || selected == '<?=_PCA?>' || selected == '<?=_PCAMD?>' || selected == '<?=_PCUNK?>' || selected == '<?=_AIOI?>' || selected == '<?=_AIOA?>' || selected == 'ALLINONE <?=_PCUNK?>' || selected == '<?=_AIOAMD?>' || selected == '<?=_LAPI?>' || selected == '<?=_LAPA?>' || selected == '<?=_LAPUN?>' || selected == '<?=_LAPAMD?>' || selected == 'TFT Monitors' || selected == '<?=_SERVER?>' || selected === '<?=_NETWRK?>' || selected == '<?=_APPPHNE?>' || selected == '<?=_SMRTPHNE?>' || selected == '<?=_APPTAB?>' || selected == '<?=_TAB?>' || selected == '<?=_TV?>') {

                        if (!isNaN(working) && working.length !== 0) {
                            totalqty += parseFloat(working);
                        }
                    }
                }
                console.log(totalqty);


                if (totalqty >= 25) {
                    chargable = 0;
                    $('#charge').hide();
                }
                if (totalqty < 25) {
                    chargable = 1;
                    $('#charge').show();
                    console.log(totalqty);

                }

            });
        });


        $('#tb').on('click', 'tbody tr', function (event) {
            totalqty = 0;
            $('#tb tr').each(function () {
                var working = Number($(this).find(".working").val());
                var selected = $(this).find(".select-parts option:selected").html();
                other1del = $(this).find(".select-parts option[value='19']").val();
                other2del = $(this).find(".select-parts option[value='21']").val();
                other3del = $(this).find(".select-parts option[value='23']").val();

                console.log(other1del);
                console.log(selected);


                idd = $(this).closest('tr').attr('id');
                console.log(idd);


                $('.select-parts').on('change', function () {

                    arr = [];
                    newArray = [];


                });


            });


            $(".select-parts").each(function () {


                if ($(this).val() == 'de') {

                    $('#' + idd).find(".working").prop('disabled', true);


                }


                arr.push($(this).val());


                newArray = arr.filter(function (v) {
                    return v !== null
                });
                console.log(newArray);
                thepast.push($(this).val());
                var hisarr = thepast.filter(function (v) {
                    return v !== null
                });

                history = jQuery.unique(hisarr);
                console.log(history);
            });


            function checkValue(value, arr) {
                var status = 'Not exist';

                for (var i = 0; i < arr.length; i++) {
                    var name = arr[i];
                    if (name == value) {
                        status = 'Exist';
                        break;
                    }
                }

                return status;
            }


            var i;
            for (i = 0; i < history.length; ++i) {
                var vh = history[i];
//  // console.log( 'Index : ' + newArray.indexOf(vh) );

                console.log(checkValue(vh, newArray));

                var check = checkValue(vh, newArray);

                if (check == 'Not exist') {

//       console.log(vh + '-'+ selpoint);
                    $(".select-parts option[value=" + vh + "]").prop('disabled', false);
                }

            }


            var i;

            for (i = 0; i < newArray.length; ++i) {

                var vv = newArray[i];


                $(".select-parts option[value=" + vv + "]").prop('disabled', function () {


                    selpoint = this.value;
                    console.log(selpoint + '-' + vv);

                    return this.value == vv;

                });


            }


            newArray = [];


        });

        var i = 0;


        $('#addmore2').on('click', function () {

// $.MessageBox('hello');
            var previous2 = $("#row" + id + " .select-parts").html();
            console.log(previous2);

            if (previous2 == 'de') {


                addlimit--;

                if (addlimit < 0) {

                    addlimit = 0;
                }

                //$.MessageBox('please fill in line.');

            } else {
                $('#addMore').click();
            }


        });

        $('#bioscheck').click(function () {

            if ($("#bioscheck").prop("checked") == true) {
                $("#biopass").attr('disabled', true);
                $("#biopass").val('N/A');
            } else if ($("#bioscheck").prop("checked") == false) {
                $("#biopass").attr('disabled', false);
                $("#biopass").val('');

            }
            ;
        });


        $('input[type="checkbox"]').click(function () {

            if ($("#expmt").prop("checked") == true) {
                $("#prem").attr('disabled', true);
                $("#prem").val('EXEMPT');

            } else {
                $("#prem").attr('disabled', false);
                $("#prem").val(' ');

            }

        });
        if ($("#prem").val() == '') {
            $("#prem").val('EXEMPT');
            $("#expmt").prop("checked", true);
        }

// if($('parts option:selected').val()=='PC'){


// console.log('pc');


// }


        var ItemArray = [];


        $('#country').on('change', function () {
            if ($("#country option:selected").text() == 'Wales') {

                // $.MessageBox('hello');
                $("#expmt").prop("checked", false);
                $("#prem").val(" ");
                $('#premisestuff').show();

            } else {
                $("#prem").val("EXEMPT");
                $('#premisestuff').hide();

            }
        });


        $('.select-parts').on('change', function () {

            if (part == '<?=_PCA?>' || part == '<?=_AIOA?>' || part == '<?=_LAPA?>' || part == '<?=_APPPHNE?>' || part == '<?=_APPTAB?>') {

                $('#applenote').show();

            }

            arr = [];
            newArray = [];


            var part = $('#row0 #part option:selected').text();
            var partother = $('#row0 #part option:selected').val();
            ///   $.MessageBox(part);


            if (part == '<?=_PCI?>' || part == '<?=_PCA?>' || part == '<?=_PCAMD?>' || part == '<?=_PCUNK?>' || part == '<?=_AIOI?>' || part == '<?=_AIOA?>' || part == '<?=_AIOAMD?>' || part == 'ALLINONE <?=_PCUNK?>' || part == '<?=_LAPI?>' || part == '<?=_LAPA?>' || part == '<?=_LAPAMD?>' || part == '<?=_LAPUN?>' || part == 'TFT Monitors' || part == '<?=_SERVER?>' || part === '<?=_NETWRK?>' || part == '<?=_APPPHNE?>' || part == '<?=_SMRTPHNE?>' || part == '<?=_APPTAB?>' || part == '<?=_TAB?>' || part == '<?=_TV?>') {

                $(this).css('background-color', '#bcdf20');

            } else {
                $(this).css('background-color', '');
            }

            if (part == 'TFT Monitors' || part == '<?=_NETWRK?>' || part == '<?=_HRDDRIVE?>' || part == '<?=_SERVER?>') {

                $('#tb tr').find("td:eq(4)").find('.w').hide();
                $('#tb tr').find("td:eq(4)").find('.w').prop("checked", false);
            } else {
                $('#tb tr').find("td:eq(4)").find('.w').show();
            }

            if (part == 'CRT Monitors' || part == '<?=_PROJ?>' || part == '<?=_DESK?>' || part == '<?=_STANDPRI?>' || part == '<?=_SMRTBOARD?>' || part == '<?=_LAPTRO?>' || partother == 19 || partother == 21 || partother == 23) {

                $('#tb tr').find("td:eq(4)").find('.w').hide();
                $('#tb tr').find("td:eq(4)").find('.w').prop("checked", false);
                $('#tb tr').find("td:eq(3)").find('.v').hide();
                $('#tb tr').find("td:eq(3)").find('.v').prop("checked", false);
            } else if (part == 'TFT Monitors' || part == '<?=_NETWRK?>' || part == '<?=_HRDDRIVE?>' || part == '<?=_SERVER?>' || part == '<?=_APPPHNE?>' || part == '<?=_SMRTPHNE?>' || part == '<?=_APPTAB?>' || part == '<?=_TAB?>' || part == '<?=_TV?>') {

                $('#tb tr').find("td:eq(4)").find('.w').hide();
                $('#tb tr').find("td:eq(4)").find('.w').prop("checked", false);
            } else {

                $('#tb tr').find("td:eq(4)").find('.w').show();
                $('#tb tr').find("td:eq(3)").find('.v').show();

            }


        });


//   $('#formstuff').submit(function(e) {
//     e.preventDefault();
//     var or = $("#org").val();
//   var emai = $("#email").val();
//   var te = $("#tel").val();
//   var pre = $("#prem").val();
//   var ad1 = $("#add1").val();
//   var ad2 = $("#add2").val();
//   var ad3 = $("#add3").val();
//   var tw = $("#twn").val();
//   var postcod  = $("#postc").val();
//   var contac = $("#cont").val();
//   var contactph = $("#contph").val();
//   var colldateno = $("#coldate").val();
//   var colinstruc = $("#colins").val();
//   var requstco = $("#reqcon").val();
//   var po = $("#pos").val();
//   var sic = $("#sicco").val();

//     $(".error").remove();

//     if (or.length < 1) {
//       $('#org').after('<span class="error">This field is required</span>');
//     }
//     if (emai.length < 1) {
//       $('#tw').after('<span class="error">This field is required</span>');
//     }
//     if (te.length < 1) {
//       $('#tel').after('<span class="error">This field is required</span>');
//     }
//     if (ad1.length < 1) {
//       $('#ad1').after('<span class="error">This field is required</span>');
//     }
//     if (postcod.length < 1) {
//       $('#contac').after('<span class="error">This field is required</span>');
//     } else {
//       var regEx = /^[A-Z0-9][A-Z0-9._%+-]{0,63}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/;
//       var validEmail = regEx.test(email);
//       if (!validEmail) {
//         $('#emai').after('<span class="error">Enter a valid email</span>');
//       }
//     }
//     if (sic.length < 8) {
//       $('#sicco').after('<span class="error">Password must be at least 8 characters long</span>');
//     }
//   });
//   $('form[id="formstuff"]').validate({
//     rules: {
//         Organisation: 'required',
//         country: 'required',
//       user_email: {
//         required: true,
//         email: true,
//       },
//       SICcode: {
//         required: true,
//         minlength: 5,
//       }
//     },
//     messages: {
//         Organisation: 'This field is required',
//         country: 'This field is required',
//       user_email: 'Enter a valid email',
//       SICcode: {
//         minlength: 'SIC-code must be at least 8 characters long'
//       }
//     },
//     submitHandler: function(form) {
//     form.submit();

//   }
// });


        $('#additem').on('click', function () {
            $.trim($('#newitem').remove("script"));
            var value = $.trim($('#newitem').val());


            console.log(value);

            if (!value || value === ' ') {

                $.MessageBox('<?php echo _ENTERASSET ?>');

            } else {


                var previous3 = $("#row" + id + " .select-parts").val();

                if (previous3 == 'de') {


                    addlimit--;

                    if (addlimit < 0) {

                        addlimit = 0;
                    }
                    //$.MessageBox('please fill in line.')

                } else {
                    if (count > 0) {
                        othercount++;
                        val++;
                        val++;
                        count--;
//  $.MessageBox(val);

                        othercheck++;


                        $cont_stat = $('#limit').html("<p><strong><?=_ENTRYLEFT?>:</strong> " + count + "</p>");


//$cont_stat.css("font-weight","Bold");

//$('.select-parts').append('<option value="'+val+'" id="other'+othercount+'">'+ value +' </option>');

                        newline = '<option value="' + val + '"  id="other' + othercount + '">' + value + ' </option>'

                        newline2 = '<option value="' + val + '"  id="other' + othercount + '">' + value + ' </option>'


                        $("#addMore").click();


                        $("#row" + id + " .working").prop('disabled', false);
//$("#row"+id+" .notworking").prop('disabled', false);


                    }
                    if (count <= 0) {
                        $cont_stat = $('#limit').text("No additional lines left.");
                        $("#newitem").prop('disabled', true);
                    } else {
                        $("#newitem").prop('disabled', false);
                    }

                    $("#newitem").val(" ");
                    // $.MessageBox("Your item has been added to item list below.");


                    $("#row" + id + " .select-parts").val(val);
                    $("#row" + id + " .w").hide();
                    $("#row" + id + " .w").prop("checked", false);
                    $("#row" + id + " .v").hide();
                    $("#row" + id + " .v").prop("checked", false);


                }
                // here
            }
        });


        if ($("#row" + id + " .working").val() == '') {

            $("#row" + id + " .working").val('0');


        }

        // if($("#row"+id+" .notworking").val() == ''){

//$("#row"+id+" .notworking").val('0');

//}


        $('#addMore').on('click', function () {


            addlimit++;

            // $.MessageBox(addlimit);


            if (addlimit >= 33) {


                $('#addMore').prop('disabled', true);

                $('#addMore2').prop('disabled', true);


                $.MessageBox('<?php echo _NOMORE ?>');


            } else {
                ///$('.select-parts').append('<option value="foo" selected="selected">Foo</option>');

                $('#addMore').prop('disabled', false);

                $('#addMore2').prop('disabled', false);


                var previous = $("#row" + id + " .select-parts").val();
                var workin = $("#row" + id + " .working").val();
                // var notworkin = $("#row"+id+" .notworking").val();

                if (previous == 'de') {


                    addlimit--;

                    if (addlimit < 0) {

                        addlimit = 0;
                    }

                    // $.MessageBox('please fill in line.')
                    $("#err").removeAttr("hidden");
                } else {

                    $("#err").attr("hidden", "");
                    if ($("#row" + id + " .v").prop("checked") == true) {
                        assettick = 1;


                    } else if ($("#row" + id + " .v").prop("checked") == false) {
                        assettick = 0;


                    }

                    if ($("#row" + id + " .w").prop("checked") == true) {
                        wipetick = 1;


                    } else if ($("#row" + id + " .w").prop("checked") == false) {
                        wipetick = 0;


                    }


                    console.log(pre);

                    id++;
                    i++;


                    var da = $("#tb tr:last").after("<tr id='row" + id + "'>"
                        + "<td>"
                        + "<div class='control-group'>"
                        + "<div class='dropdown'>"
                        + "<select name='select-parts' id='part' class='form-control select-parts'>"
                        + "<option value='de' selected>Select Part Type</option>"
                        + "<option value='3'><?=_PCI?></option> "
                        + "<option value='71'><?=_PCA?></option>"
                        + "<option value='53'><?=_PCAMD?></option> "
                        + "<option value='55'><?=_PCUNK?></option>"
                        + " <option value='75'><?=_AIOI?></option>"
                        + " <option value='31'><?=_AIOA?></option>"
                        + " <option value='63'><?=_AIOAMD?></option> "
                        + " <option value='61'> <?=_PCUNK?></option> "
                        + "<option value='5'><?=_LAPI?></option> "
                        + "<option value='73'><?=_LAPA?></option> "
                        + " <option value='59'><?=_LAPAMD?></option> "
                        + " <option value='57'><?=_LAPUN?></option> "
                        + "<option value='47'><?=_SMRTPHNE?></option>  <option value='45'><?=_APPPHNE?></option>"
                        + "<option value='33'><?=_NONPHNE?></option>"
                        + "   <option value='49'><?=_APPTAB?></option>"
                        + " <option value='51'><?=_TAB?></option>"
                        + "  <option value='11'>TFT Monitors</option>"
                        + " <option value='15'><?=_TV?></option>"
                        + "<option value='7'><?=_SERVER?></option>"
                        + "<option value='43'><?=_NETWRK?></option>"
                        + "<option value='17'><?=_HRDDRIVE?></option>"
                        + " <option value='29'><?=_SMRTBOARD?></option>"
                        + "   <option value='9'><?=_PROJ?></option>"
                        + "<option value='25'><?=_DESK?></option>"
                        + "<option value='27'><?=_STANDPRI?></option>"
                        + "   <option value='41'><?=_LAPTRO?></option>"

                        + newline
                        + "</select>"
                        + " </div>"
                        + "</div>"
                        + "</div>"
                        + "</td>"
                        + "<td><input type='number' class='working' min='0' max='5000'  value='0'></td><td hidden><input type='number' class='notworking' min='0' max='5000'  value='0'></td>"
                        + "<td hidden><input type='checkbox' class='v' class='group1'></td><td hidden><input type='checkbox' class='w' name='wipe' class='group1'></td>"
                        + "<td class='delline'><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a>"
                        + "<span class='tooltiptext2'><?= _REMOVELINE ?></span></td>"
                        + "</tr>")


                    newline = '';

                    if (othercheck == 1) {

                        $("#row" + id + " .working").prop('disabled', false);

//$("#row"+id+" .notworking").prop('disabled', false);

                        othercheck = 0;


                    }


                    $("#tb tr").find(".select-parts").on('change', function () {

                        arr = [];
                        newArray = [];


                        var partex = $("#row" + id + "").find('.select-parts option:selected').text();
                        var partotherex = $("#row" + id + "").find('.select-parts option:selected').val();
// $.MessageBox(partex);


//    $.MessageBox('hit');
//    var self = $('#row0 #part option:selected').val();
//     console.log(self);
//  $('#row1 .select-parts').find('option').prop('disabled', function() {
//    console.log(this.value);
//      return this.value == self
//  });


                        if (partex !== 'de') {
                            $("#row" + id + " .working").prop('disabled', false);

//$("#row"+id+" .notworking").prop('disabled', false);

                        } else {

                            $("#row" + id + " .working").prop('disabled', true);

//$("#row"+id+" .notworking").prop('disabled', true);

                        }


                        if (partex == '<?=_PCI?>' || partex == '<?=_PCA?>' || partex == '<?=_PCUNK?>' || partex == '<?=_PCAMD?>' || partex == '<?=_AIOI?>' || partex == '<?=_AIOA?>' || partex == 'ALLINONE <?=_PCUNK?>' || partex == '<?=_AIOAMD?>' || partex == '<?=_LAPI?>' || partex == '<?=_LAPA?>' || partex == '<?=_LAPUN?>' || partex == '<?=_LAPAMD?>' || partex == 'TFT Monitors' || partex == '<?=_SERVER?>' || partex == '<?=_NETWRK?>' || partex == '<?=_APPPHNE?>' || partex == '<?=_SMRTPHNE?>' || partex == '<?=_APPTAB?>' || partex == '<?=_TAB?>' || partex == '<?=_TV?>') {


                            $(this).css('background-color', '#bcdf20');

                        } else {
                            $(this).css('background-color', '');

                        }


                        if (partex == 'CRT Monitors' || partex == '<?=_PROJ?>' || partex == '<?=_DESK?>' || partex == '<?=_STANDPRI?>' || partex == '<?=_LAPTRO?>' ||
                            partex == '<?=_SMRTBOARD?>' || partotherex == 19 || partotherex == 21 || partotherex == 23) {

                            $("#row" + id + " .w").hide();
                            $("#row" + id + " .v").hide();
                            $("#row" + id + " .w").prop("checked", false);
                            $("#row" + id + " .v").prop("checked", false);
                        } else if (partex == 'TFT Monitors' || partex == '<?=_NETWRK?>' || partex == '<?=_HRDDRIVE?>' || partex == '<?=_SERVER?>' || partex == '<?=_APPPHNE?>' || partex == '<?=_SMRTPHNE?>' || partex == '<?=_APPTAB?>' || partex == '<?=_TAB?>' || partex == '<?=_TV?>') {

                            $("#row" + id + " .w").hide();
                            $("#row" + id + " .w").prop("checked", false);
                            $("#row" + id + " .v").show();
                        } else {

                            $("#row" + id + " .w").show();
                            $("#row" + id + " .v").show();


                        }


                    });


                    //  $.MessageBox("a new line has been added");

                }

            }


        });


        $('#formstuff').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });


//$("#testbutt").click(function(){

        $('#formstuff').submit(function (e) {

            e.preventDefault();
            daystring = "";
            $("input:checkbox[name='days']:checked").each(function(){ 
             avalidays = [];
            avalidays.push($(this).val()); 
            daystring += avalidays.join(", ")+',';		
  		});
            //uploadimage();
            console.log(daystring.slice(0, -1));
            


            var other1name
            if ($('#other1').length) {
                other1name = $('#other1').text();

                // $.MessageBox(other1name);
            }


            var other2name
            if ($('#other2').length) {
                other2name = $('#other2').text();

                // $.MessageBox(other2name);
            }


            var other3name
            if ($('#other3').length) {
                other3name = $('#other3').text();

                // $.MessageBox(other3name);
            }


//var newArray = ItemArray.filter(function(v){return v!==''});


// var newArray = ItemArray.filter(function (el) {
//   return el != null;
// });

            console.log(ItemArray);


            var org = $("#org").val();
            var email = $("#email").val();
            var tel = $("#tel").val();
            var prem = $("#prem").val();
            var add1 = $("#add1").val();
            var add2 = $("#add2").val();
            var add3 = $("#add3").val();
            var twn = $("#twn").val();
            var postcode = $("#postc").val();
            var contact = $("#cont").val();
            var contactphne = $("#contph").val();
            var colldatenote = $("#coldate").val();
            var access = $('#early option:selected').val();
            var onsite = $('.onsite option:selected').val();
            var avoid = $('#avoid').val();
            var colinstruct = $('#avoidissue').val();

            var ground = $('.ground option:selected').val();
            var lift = $('.lift option:selected').val();
            var steps = $('.steps option:selected').val();
            var parking = $('.park option:selected').val();
            var twoman = $('.twoman option:selected').val();
            //var colinstruct = $("#colins").val();
            var requstcon = $("#reqcon").val();
            var pos = $("#pos").val();
            //var sic = $("#sicco").val();
            var biopass = $("#biopass").val();


            console.log(biopass);


            var country = $('#country option:selected').val();


            if ($("#expmt").prop("checked") === true) {
                is_exempt = 1;


            }
            if ($("#expmt").prop("checked") === false) {
                is_exempt = 0;

            }


// $.MessageBox(is_exempt);


            $(".error").remove();
            var vali = 1;
            //var errcount = 0;


            var cworking = $("#row" + id + " .working").val();

            // var cnotworking  = $("#row"+id+" .notworking").val();

            var oworking = $("#row0 .working").val();

            //var onotworking  = $("#row0 .notworking").val();


            var RegExphne = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/;

            var valtel = RegExphne.test(tel);
            var valphone = RegExphne.test(contactphne);

            var regEx = /^[A-Z0-9][A-Z0-9._%+-]{0,63}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/;

            if (twoman == "Please Select...") {

                $('.twoman').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 19) {
                    $('html, body').animate({
                        scrollTop: ($('.twoman').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;


                json = '';

            }

            if (ground == "Please Select a option..") {

                $('.ground').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.ground').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;


                json = '';

            }

            if ($('#file')[0].files.length === 0) {
                $('#errpic').text('At least one image most be uploaded before submitting.');
                $('#errpic').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#file').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;


                json = '';
            }

            if (lift == "Please Select a option..") {

                $('.lift').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.lift').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;


                json = '';

            }
            if (steps == "Please Select a option..") {

                $('.steps').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.steps').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;


                json = '';

            }

            if (onsite == "Please select a option...") {

                $('.onsite').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.onsite').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;


                json = '';

            }

            if (parking == "Please Select Description...") {

                $('.parking').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.parking').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;
                json = '';
            }
            if (!avoid) {

                $('.avoidcas').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.avoidcas').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;
                json = '';
            }
            if (access == 'Please Select a option..') {

                $('.eaccess').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.eaccess').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;
                json = '';
            }
            var validEmail = regEx.test(email);
            if ($("#confirmed").prop("checked") === false) {


                $('#confirmed').after('<br><span class="error" style="color:red"><?= _SELECTOPTION ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#confirmed').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;


                json = '';

            }
            if (org.length < 3 || org.length > 50) {
                // ItemArray = [];

                $('#org').after('<br><span class="error" style="color:red"><?= _TWNRANGELNG ?></span>');
                $('#er').show();
                vali = 0;
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#org').offset().top)
                    }, 500);
                }
                errcount++;
                // $.MessageBox(vali);

                json = '';
            }

            if (biopass.length < 1) {
                // ItemArray = [];
                $('#bioscheck').after('<br><span class="error" style="color:red"><?= _REQ ?></span>');
                $('#er').show();
                vali = 0;
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#bioscheck').offset().top)
                    }, 500);
                }
                errcount++;
                //  $.MessageBox(vali);

                json = '';
            }
            if (twn.length < 1) {
                // ItemArray = [];
                $('#twn').after('<br><span class="error" style="color:red"><?= _REQ ?></span>');
                $('#er').show();
                vali = 0;
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#twn').offset().top)
                    }, 500);
                }
                errcount++;
                // $.MessageBox(vali);

                json = '';
            }
            if (tel.length < 10) {
                // ItemArray = [];
                $('#tel').after('<br><span class="error" style="color:red"><?= _TELRANGELNG ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#tel').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;
                // $.MessageBox(vali);

                json = '';
            }
            if (!valtel) {
                //  ItemArray = [];
                $('#tel').after('<br><span class="error" style="color:red"><?= _TELVALID ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#tel').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;
                //  $.MessageBox(vali);

                json = '';
            }
            if (!valphone) {
                // ItemArray = [];
                $('#contph').after('<br><span class="error" style="color:red"><?= _TELVALID ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#contph').offset().top)
                    }, 500);
                }

                vali = 0;
                errcount++;
                //  $.MessageBox(vali);

                json = '';
            }
            if (add1.length < 5) {
                // ItemArray = [];
                $('#add1').after('<br><span class="error" style="color:red"><?= _REQ ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#add1').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;
                // $.MessageBox(vali);

                json = '';
            }
            if (postcode.length < 6 || postcode.length > 10) {
                // ItemArray = [];
                $('#postc').after('<br><span class="error" style="color:red"><?= _POSTCODELIM ?></span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('#postc').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;

                json = '';

            }if (daystring.length == 0) {
                // ItemArray = [];
                $('.tabledays').after('<br><span class="error" style="color:red"><?= _SELECTDAY ?> </span>');
                $('#er').show();
                if (errcount !== 21) {
                    $('html, body').animate({
                        scrollTop: ($('.tabledays').offset().top)
                    }, 500);
                }
                vali = 0;
                errcount++;

                json = '';

            } else {
                var regEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
                var validEmail = regEx.test(email);
                if (!validEmail) {
                    errcount++;
                    //ItemArray = [];
                    $('#email').after('<br><span class="error" style="color:red"><?= _ENTEREMAIL ?></span>');
                    $('#er').show();
                    if (errcount !== 21) {
                        $('html, body').animate({
                            scrollTop: ($('#email').offset().top)
                        }, 500);
                    }
                    vali = 0;
                    ///ItemArray.pop();
                    json = '';
                }
            }

            // if (sic.length < 5) {
            //     //ItemArray = [];
            //   $('#sicco').after('<br><span class="error" style="color:red">SICcode must be 5 numbers long</span>');
            //   vali = 0;
            //   // $.MessageBox(vali);
            //   //ItemArray.pop();
            //   json = '';
            // }


            if (cworking == 0 || oworking == 0) {
                //ItemArray = [];
                //  $('#addmore2').after('<br><br><span class="error" style="color:red">there cannot be empty values</span>');
                $('#er').show();
                errcount++;
                if (errcount !== 21) {
                    $('html, body').animate({

                        scrollTop: ($('#addmore2').offset().top)
                    }, 500);
                }
                vali = 0;
                // $.MessageBox(vali);
                //ItemArray.pop();
                json = '';
            }


            console.log(errcount);

            if (errcount == 17) {
                $('#er').show();

                $('html, body').animate({
                    scrollTop: ($('.header').offset().top)
                }, 500);


                errcount = 0;
                vali = 0;
                json = '';

            }


            //console.log(json);


            if (vali == 0) {
                deluploadimage();
                $('#tb tr').each(function () {
                    var part = $(this).find(".select-parts option:selected").val();
                    var working = $(this).find(".working").val();
                    //var notworking = $(this).find(".notworking").val();
                    var f_workin = 0;
                    var f_assettick = 0;


                    if (working == 0) {


                        //ItemArray = [];
                        $('#addmore2').after('<br><br><span class="error" style="color:red"><?= _EMPTYVAL ?></span>');
                        $('#er').show();
                        errcount++;
                        if (errcount !== 21) {
                            $('html, body').animate({
                                scrollTop: ($('#addmore2 .error').offset().top)
                            }, 500);
                        }
                        vali = 0;
                        // $.MessageBox(vali);
                        //ItemArray.pop();
                        json = '';

                    }


                    if ($(this).find(".v").prop("checked") == true) {

// if ( $( "#v" ).length ) {
                        f_assettick = 1;


                    } else if ($(this).find(".v").prop("checked") == false) {

                        //  if ( $( "#v" ).length ) {
                        f_assettick = 0;

                        //  }


                    }

                    if ($(this).find(".w").prop("checked") == true) {

                        //  if ( $( "#v" ).length ) {
                        f_wipetick = 1;

                        // }


                    } else if ($(this).find(".w").prop("checked") == false) {
                        //  if ( $( "#v" ).length ) {
                        f_wipetick = 0;

                        // }


                    }


                    //  ItemArray = [];
                    if (working != undefined) {
                        ItemArray.push({id: part, working: working, asset: f_assettick, wipe: f_wipetick});
                    }


                });
                //ItemArray.splice(0, 1);

//  $.MessageBox(ItemArray);

                var json = JSON.stringify(ItemArray);

//var jsonclean = json.replace(",{}", " ");

//jsonsuperclean = jsonclean.replace(',{"asset":0,"wipe":0}', ' ');


                console.log(ItemArray);
                console.log(json);

                ItemArray = [];


            } else if (vali == 1 && check == 0) {


                e.preventDefault();
                json = '';
                $('#myModal').css("display", "block");
                uploadimage();

            } else if (vali == 1 && check == 1) {

                $('#tb tr').each(function () {

                    var part = $(this).find(".select-parts option:selected").val();
                    var working = $(this).find(".working").val();
                    //var notworking = $(this).find(".notworking").val();
                    var f_workin = 0;
                    var f_assettick = 0;

                    console.log(this);


                    // $.MessageBox(part);


                    if ($(this).find(".v").prop("checked") == true) {

// if ( $( "#v" ).length ) {
                        f_assettick = 1;


                    } else if ($(this).find(".v").prop("checked") == false) {

                        //  if ( $( "#v" ).length ) {
                        f_assettick = 0;

                        //  }

                    }

                    if ($(this).find(".w").prop("checked") == true) {

                        //  if ( $( "#v" ).length ) {
                        f_wipetick = 1;

                        // }


                    } else if ($(this).find(".w").prop("checked") == false) {
                        //  if ( $( "#v" ).length ) {
                        f_wipetick = 0;

                        // }

                    }

                    //  ItemArray = [];
                    if (working != undefined) {
                        ItemArray.push({id: part, working: working, asset: f_assettick, wipe: f_wipetick});
                    }


                });
                //ItemArray.splice(0, 1);

                // $.MessageBox(ItemArray);

                var json = JSON.stringify(ItemArray);

//var jsonclean = json.replace(",{}", " ");

//jsonsuperclean = jsonclean.replace(',{"asset":0,"wipe":0}', ' ');


                //console.log(ItemArray);

                console.log(json);

  		



            


//console.log(uploadcomp);


                if (vali == 1) {

                    $("#agree").prop('disabled', true);
                    $("#disagree").prop('disabled', true);

                    $.ajax({
                        type: "POST",
                        url: "/booking/update",
                        data: {
                            org: org,
                            email: email,
                            tel: tel,
                            prem: prem,
                            add1: add1,
                            add2: add2,
                            add3: add3,
                            twn: twn,
                            postcode: postcode,
                            contact: contact,
                            contactphne: contactphne,
                            colldatenote: colldatenote,
                            colinstruct: colinstruct,
                            onsite: onsite,
                            access: access,
                            avoid: avoid,
                            ground: ground,
                            lift: lift,
                            steps: steps,
                            parking: parking,
                            twoman: twoman,
                            requstcon: requstcon,
                            pos: pos,
                            biopass: biopass,
                            json: json,
                            other1name: other1name,
                            other2name: other2name,
                            other3name: other3name,
                            country: country,
                            chargable: chargable,
                            daystring : daystring,
                            //sic : sic,
                            is_exempt: is_exempt

                        },
                        dataType: "json",
                        success: function (data) {
                            // $.MessageBox(data);
                            $.MessageBox("<?= _THANKYOUTXT ?>");

                        }
                    });

                    if (uploadcomp == 1) {
                        setTimeout(function () {
                            window.location.replace("/booking/thankyou");
                        }, 6000);
                    }

                }

            }


        });


        $(document).on('click', '.remove', function () {


            var addback = 0;
            var working = $(this).find(".working").val();
            // var working = $(this).find(".notworking").val();
            var newrow = $(this).find(".select-parts").val();

            // $.MessageBox($(this).find(".select-parts").val());


            var working = Number($(this).find(".working").val());
            var selected = $(this).find(".select-parts option:selected").html();


            other1delre = $(this).closest("tr").find(".select-parts option[value='19']").val();
            other2delre = $(this).closest("tr").find(".select-parts option[value='21']").val();
            other3delre = $(this).closest("tr").find(".select-parts option[value='23']").val();


            if (other1delre == 19) {

                addback++;
                othercount--;
                val--;
                val--;

                console.log("other del:" + other1delre);

                count++;
                $cont_stat = $('#limit').html("<p><strong><?=_ENTRYLEFT?>:</strong> " + count + "</p>");

            }

            if (other2delre == 21) {

                addback++;
                othercount--;
                val--;
                val--;
                console.log("other del:" + other2delre);
                count++;
                $cont_stat = $('#limit').html("<p><strong><?=_ENTRYLEFT?>:</strong> " + count + "</p>");

            }
            if (other3delre == 23) {

                addback++;
                othercount--;
                val--;
                val--;
                console.log("other del:" + other3delre);
                count++;
                $cont_stat = $('#limit').html("<p><strong><?= _ENTRYLEFT?>:</strong> " + count + "</p>");

            }

            if (count !== 0) {

                $('#newitem').prop('disabled', true);
            }

            if (count > 0) {

                $('#newitem').prop('disabled', false);
            }


            var trIndex = $(this).closest("tr").index();

            // $.MessageBox($(this).closest("tr").find(".select-parts  option[value='19']").val());
            //    $.MessageBox(newrow);
            if (trIndex > -1) {
                // $(this).closest("tr").remove();

                $(this).closest("tr").find("td:eq(4)").remove();
                $(this).closest("tr").find("td:eq(3)").remove();
                $(this).closest("tr").find(".v").remove();
                $(this).closest("tr").find(".w").remove();
                $(this).closest("tr").remove();

                //f_assettick = 0;
                // f_wipetick = 0;


            } else {
                //   $.MessageBox("Sorry!! Can't remove first row!");

            }
        });


        function uploadimage() {

            var uploadcheck = 0;

            var imgs = 0;
            var fd = new FormData();
            jQuery.each(jQuery('input[type=file]'), function (i, value) {

                filestuff = $(this).val();

                console.log('BBBB')
                console.log(i)
                console.log(filestuff)
                console.log(value)
                //  $.MessageBox(filestuff);

                if (!filestuff) {
                    console.log("no files");

                    imgs++;

                    if (imgs == 5) {

                        uploadcheck = 1;
                        filecheck = uploadcheck;

                    }


                } else {
                    uploadcheck = 0;

                    filecheck = uploadcheck;


                    var filetypestr = filestuff.substr((filestuff.lastIndexOf('.') + 1));
                    console.log('BBBB:' + filetypestr)

                    if (filetypestr == '') {

                    } else {
                        console.log(filetypestr);
                        if (filetypestr === 'jpg' || filetypestr === 'JPG' || filetypestr === 'png' || filetypestr === 'jpeg') {
                            var filesize = value.files[0].size;
                            console.log(filesize);

                            fd.append('inputfile[' + i + ']', value.files[0]);


                            const size =
                                (filesize / 1024 / 1024).toFixed(2);
                            //console.log(fd.get("inputfile"));
                        } else if (size > 36 || size < 0) {
                            $.MessageBox("<?= _FILESIZE ?>" + size);
                        } else {
                            $.MessageBox("<?= _NOTSUP ?>");
                        }


                    }
                }

            });
            // var fd1 = new FormData();
            // var files1 = $('#file1')[0].files1[0];
            // fd1.append('inputfile1',files1);

            // var fd2 = new FormData();
            // var files2 = $('#file2')[0].files2[0];
            // fd2.append('inputfile2',files2);

            if (filecheck == 0) {
                $.ajax({
                    url: '/booking/upload',
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    cache: false,             // To unable request pages to be cached
                    processData: false,        // To send DOMDocument or non processed data file it is set to false
                    success: function (response){
                        if (response != 0) {
                            //  $.MessageBox('uploaded');
                        } else {
                            //  $.MessageBox('file not uploaded');
                        }
                    },
                });
            }
            uploadcomp = 1;

        }

//showsize();
// function showsize(){

//   var total = 0;
//   $('input[type=file]').on('change', function() {
//  // $('input[type=file]').each(function(i, value)

//               console.log((this.files[0].size/1024/1024).toFixed(2) );
//              var size = (this.files[0].size/1024/1024).toFixed(2);
//              return size;
//          //console.log(filestuff.files.size);
//   //});


// });
// }
        function deluploadimage() {


            var del = 1;
// var fd1 = new FormData();


// var fd2 = new FormData();
// var files2 = $('#file2')[0].files2[0];
            var fd = new FormData();
            jQuery.each(jQuery('input[type=file]'), function (i, value) {
                fd.append('inputfile[' + i + ']', value.files[0]);

                console.log(fd.get("inputfile"));
            });
            fd.append('del', 1);


            $.ajax({
                url: '/booking/upload',
                type: 'POST',
                data: fd,
                contentType: false,
                cache: false,             // To unable request pages to be cached
                processData: false,        // To send DOMDocument or non processed data file it is set to false
                success: function (response) {
                    if (response != 0) {
                        //  $.MessageBox('uploaded');
                    } else {
                        //   $.MessageBox('file not uploaded');
                    }
                },
            });

        }


    });
</script>