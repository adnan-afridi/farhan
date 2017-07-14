<!--Content-->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="profile get-connected">
                        <!--left menu-->
                        <?php require_once 'includes/left-menu.php'; ?>

                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <div class="profile-cont">
                                    <div class="connect-title">
                                        <h5>Let your <span>DREAM LIGHT</span> shine bright so that other  <span>DREAMERS</span>  can connect with you</h5>
                                    </div>
                                    <div class="map-banner" id="map">
                                    </div>
                                    <div class="elements-group">
                                        <div class="col-md-6">
                                            <div class="elements-items">
                                                <ul>
                                                    <li><img src="<?php echo base_url(); ?>assets/images/mark-img1.png" alt="" title=""><span>Complementary</span></li>
                                                    <li><img src="<?php echo base_url(); ?>assets/images/mark-img2.png" alt="" title=""><span>Similar</span></li>
                                                    <li><img src="<?php echo base_url(); ?>assets/images/mark-img3.png" alt="" title=""><span>Friends</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="search-items pull-right">
                                                <form method="post" action="<?php echo base_url('Users/search_users'); ?>">
                                                    <input type="text" name="search" class="search-user" placeholder="Search...">
                                                    <input type="submit" id="search-btn">
                                                </form>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="connects-wrap">
                                        <div class="connects-users">

                                        </div>
                                        <div class="connects-users">
                                            <?php
                                            if ($users) {

                                                foreach ($users as $user_info) {
                                                    ?>
                                                    <div class="row marginTop10">
                                                        <div class="col-md-3">
                                                            <div class="user-img">
                                                                <img src="<?php echo $img = (!empty($user_info['profile_image'])) ? base_url()."assets/images/profile_images/".$user_info['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="">
                                                                <h3><?php echo $user_info['first_name'].' '.$user_info['last_name']; ?></h3>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="text-area">
                                                                <h6><?php echo ($user_info['profile_desc']) ? $user_info['profile_desc'] : 'No information yet.'; ?></h6>
                                                                <div class="connects-btns">
                                                                    <a href="<?php echo base_url('Main?id='.$user_info['ID']); ?>">Profile</a>
                                                                    <?php if ($user_info['relation'] == '1') { ?>
                                                                        <a href="#" user="<?php echo $user_info['ID']; ?>" class="un-friend" >Unfriend</a>
                                                                        <?php
                                                                    }
                                                                    else if ($user_info['relation'] == '0') {
                                                                        ?>
                                                                        <a href="javascript:void(0)" user="<?php echo $user_info['ID']; ?>" class="un-friend">Cancel Request</a>
                                                                        <?php
                                                                    }
                                                                    else {
                                                                        ?>
                                                                        <a href="javascript:void(0)" user="<?php echo $user_info['ID']; ?>" class="connect-to">Connect</a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            else {
                                                echo "<div>No friends.</div>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>	
<!--Cloud-->
<div id="awan"></div>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 100%;
    }
</style>
<script async  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzgQTfcr-EOLOPFmVFxlp467KAw3LoTPo&callback=initMap"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/map/jquery.ui.map.js"></script>


<script type="text/javascript">
    
    function initMap() {


        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: new google.maps.LatLng(41.850033, -87.6500523),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        $.getJSON('<?php echo base_url(); ?>Users/markers', function (data) {
//                                console.log(data);
            $.each(data.markers, function (i, user) {
//                console.log(user);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(user.latitude, user.longitude),
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        var img = '<img width="25px" src="' + window.base_url + 'assets/images/profile_images/' + user.image + '" alt=""/>'
                        var info = "";
                        info += '<table>';
                        info += '<tr>';
                        info += '<td rowspan="2">' + img + '</td>';
                        info += '<td>&nbsp;&nbsp;<a href="'+window.base_url+'Main?id='+user.id+'">'+user.name+'</a></td>';
                        info += '<td>';
                        info += '</tr>';
                        
                        info += '<tr>';
                        info += '<td>&nbsp;&nbsp;' + user.city + '</td>';
                        info += '</tr>';

                        info += '</table>';
                        infowindow.setContent(info);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            });
        });


    }
</script>
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
                        $($this).text('Connect').removeClass('un-friend').addClass('connect-to').css('background', '#3d9fd9');
                    } else {
                        return false;
                    }
                }
            });

        });


    });
</script>