<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($userData);exit;
$curUser = currentuser_session();
?>

<!--Content-->
<div class="top-profile-detail">
    <div class="left-image">
        <img src="<?php echo base_url(); ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title="">
        <a href="#" class="change-btn">Change</a>
    </div>
    <div class="right-info">
        <div class="edit-btn"><img src="<?php echo base_url(); ?>assets/images/edit-icon.png" alt=""></div>
        <h2>John Doe</h2>
        <p>
            <?php echo $userData['profile_desc']; ?> 
        </p>
    </div>
</div>
<div class="big-image">
    <img src="<?php echo base_url(); ?>assets/images/banner_images/<?php echo $userData['profile_banner']; ?>" alt="" title="">
    <a href="#" class="change-btn">Change</a>
</div>
<div class="bottom-cont">
    <div class="form-line">
        <select id="state" name="state">
            <option value="">Select State</option>
            <?php
            foreach ($states as $state) {
                $selected = '';
                if ($state['name'] == $userData['state']) {
                    $selected = 'selected="selected"';
                }
                ?>
                <option value="<?php echo $state['id']; ?>" <?php echo $selected; ?>><?php echo ($state['name']) ? $state['name'] : ""; ?></option>
            <?php } ?>
        </select>
        <select id="city" name="city" class="last">
            <option value="">City</option>
        </select>
    </div>
    <div class="form-line">
        <input type="text"  name="zip" id="zip" placeholder="Zip Code"  value="<?php echo ($userData['zip']) ? $userData['zip'] : ""; ?>"/>
        <select class="last" id="interest" name="interest">
            <option  value="">Show your interest</option>
            <option <?php echo ($assesmentData['interest'] == 'Foreign language study') ? 'selected="selected"' : ""; ?> value="Foreign language study" >Foreign language study</option>
            <option <?php echo ($assesmentData['interest'] == 'Reading') ? 'selected="selected"' : ""; ?> value="Reading">Reading</option>
            <option <?php echo ($assesmentData['interest'] == 'Writing/blogging') ? 'selected="selected"' : ""; ?> value="Writing/blogging">Writing/blogging</option>
            <option <?php echo ($assesmentData['interest'] == 'Music/musical instruments') ? 'selected="selected"' : ""; ?> value="Music/musical instruments">Music/musical instruments</option>
            <option <?php echo ($assesmentData['interest'] == 'Jogging/walking') ? 'selected="selected"' : ""; ?> value="Jogging/walking">Jogging/walking</option>
            <option <?php echo ($assesmentData['interest'] == 'Horseback riding') ? 'selected="selected"' : ""; ?> value="Horseback riding">Horseback riding</option>
            <option <?php echo ($assesmentData['interest'] == 'Yoga') ? 'selected="selected"' : ""; ?> value="Yoga">Yoga</option>
            <option <?php echo ($assesmentData['interest'] == 'Team sports: volleyball, bowling, soccer') ? 'selected="selected"' : ""; ?> value="Team sports: volleyball, bowling, soccer">Team sports: volleyball, bowling, soccer</option>
            <option <?php echo ($assesmentData['interest'] == 'Card games') ? 'selected="selected"' : ""; ?> value="Card games">Card games</option>
            <option <?php echo ($assesmentData['interest'] == 'Dinner or Movie club') ? 'selected="selected"' : ""; ?> value="Dinner or Movie club">Dinner or Movie club</option>
            <option <?php echo ($assesmentData['interest'] == 'Ballroom dancing') ? 'selected="selected"' : ""; ?> value="Ballroom dancing">Ballroom dancing</option>
            <option <?php echo ($assesmentData['interest'] == 'Volunteering') ? 'selected="selected"' : ""; ?> value="Volunteering">Volunteering</option>
            <option <?php echo ($assesmentData['interest'] == 'Scrapbooking') ? 'selected="selected"' : ""; ?> value="Scrapbooking">Scrapbooking</option>
            <option <?php echo ($assesmentData['interest'] == 'Needle arts: embroidery, cross-stitch') ? 'selected="selected"' : ""; ?> value="Needle arts: embroidery, cross-stitch">Needle arts: embroidery, cross-stitch</option>
            <option <?php echo ($assesmentData['interest'] == 'Jewelry making') ? 'selected="selected"' : ""; ?> value="Jewelry making">Jewelry making</option>
            <option <?php echo ($assesmentData['interest'] == 'Drawing/painting/photography') ? 'selected="selected"' : ""; ?> value="Drawing/painting/photography">Drawing/painting/photography</option>
            <option <?php echo ($assesmentData['interest'] == 'Pottery') ? 'selected="selected"' : ""; ?> value="Pottery">Pottery</option>
            <option <?php echo ($assesmentData['interest'] == 'Antiques') ? 'selected="selected"' : ""; ?> value="Antiques">Antiques</option>
            <option <?php echo ($assesmentData['interest'] == 'Decor') ? 'selected="selected"' : ""; ?> value="Decor">Decor</option>
            <option <?php echo ($assesmentData['interest'] == 'Postcards') ? 'selected="selected"' : ""; ?> value="Postcards">Postcards</option>
            <option <?php echo ($assesmentData['interest'] == 'Genealogy') ? 'selected="selected"' : ""; ?> value="Genealogy">Genealogy</option>
            <option <?php echo ($assesmentData['interest'] == 'Hiking/letterboxing/geocaching') ? 'selected="selected"' : ""; ?> value="Hiking/letterboxing/geocaching">Hiking/letterboxing/geocaching</option>
            <option <?php echo ($assesmentData['interest'] == 'Bird-watching') ? 'selected="selected"' : ""; ?> value="Bird-watching">Bird-watching</option>
            <option <?php echo ($assesmentData['interest'] == 'Hunting/fishing') ? 'selected="selected"' : ""; ?> value="Hunting/fishing">Hunting/fishing</option>
            <option <?php echo ($assesmentData['interest'] == 'Cooking/baking') ? 'selected="selected"' : ""; ?> value="Cooking/baking">Cooking/baking</option>
            <option <?php echo ($assesmentData['interest'] == 'Knitting') ? 'selected="selected"' : ""; ?> value="Knitting">Knitting</option>
            <option <?php echo ($assesmentData['interest'] == 'Quilting') ? 'selected="selected"' : ""; ?> value="Quilting">Quilting</option>
            <option <?php echo ($assesmentData['interest'] == 'information_technology') ? 'selected="selected"' : ""; ?> value="information_technology">Information Technology</option>
        </select>
    </div>
    <div class="form-line">
        <input type="text" name="dob" id="dob" placeholder="Date of Birth" value="<?php echo $userData['dob']; ?>"/>
    </div>
    <div class="form-line">
        <input type="submit" value="Submit">
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.connect-to', function (e) {
//            console.log('connect');
            e.preventDefault();
            var $this = $(this);
            var user = $(this).attr('user');
            console.log(user);
            var data = 'user=' + user;
            $.ajax({
                type: 'POST',
                data: data,
                url: window.base_url + 'Users/connect_to',
                success: function (postBack) {
//                    console.log(postBack);
                    var data = $.parseJSON(postBack);
                    if (data.msg == 1) {
                        $($this).text('Cancel Request').removeClass('connect-to').addClass('un-friend').css({'background': '#fa5a5a', 'color': '#fff'});
                    } else {
                        return false;
                    }
                }
            });

        });


        $(document).on('click', '.un-friend', function (e) {
            e.preventDefault();
            var $this = $(this);
            var user = $(this).attr('user');
            var data = 'user=' + user;
            $.ajax({
                type: 'POST',
                data: data,
                url: window.base_url + 'Users/unfriend',
                success: function (postBack) {
//                    console.log(postBack);
                    var data = $.parseJSON(postBack);
                    if (data.msg == 1) {
                        $($this).text('Add Friend').removeClass('un-friend').addClass('connect-to').css('background', '#80befc');
                    } else {
                        return false;
                    }
                }
            });

        });


        $('#dob').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
        });


        $('#state').on('change', function (e) {
            var state = $(this).val();
            //            console.log(state);
            $.ajax({
                type: 'POST',
                url: window.base_url + 'Profile/getCities',
                data: 'state=' + state,
                success: function (callBack) {
                    var data = $.parseJSON(callBack);
                    var citiesList = '';
                    $.each(data, function (key, val) {
                        var selected = '';
                        if (val.id == "<?php echo $userData['city']; ?>") {
                            selected = 'selected="selected"';
                        }
                        citiesList += '<option value="' + val.id + '" ' + selected + '>' + val.name + '</option>';
                    });
                    $('#city').html(citiesList);
                    //                    console.log(temp);
                }
            });

        }).trigger('change');

        $('#city').on('change', function (e) {

            var state = $('#state option:selected').text();
            var city = $("#city option:selected").text();

            $.ajax({
                type: 'POST',
                url: window.base_url + 'Profile/getZipCode',
                data: 'state=' + state + 'city=' + city,
                beforeSend: function () {
                    $('#zip').val('');
                    $('#zip-preloader').removeClass('hidden');
                },
                success: function (callBack) {
                    var data = $.parseJSON(callBack);
                    //                    console.log(data);
                    $('#zip-preloader').addClass('hidden');
                    if (data.zip == null) {
                        $('#zip').attr('placeholder', 'Please type zip');
                    }
                    $('#zip').val(data.zip);
                }
            });

        })

    })
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.ajaxfileupload.js"></script>

<script>
    $("#filesToUploadP").AjaxFileUpload({

        action: '<?php echo base_url(); ?>Profile/profile_image',
        onComplete: function (filename, response) {
            $("#myProfileImage").attr('src', response.name);
            $(".myProfileImage").show();
            $("#current-profile-image").remove();
            $("#profilesrc").val(response.name);
            $('#myProfileImage').Jcrop({
                aspectRatio: 0.72,
                setSelect: [25, 40, 500, 254],
                onSelect: updateCoords
            });
        }
    });

    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }

</script>
