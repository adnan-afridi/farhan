<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--Content-->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="profile inspiration">
                        <!--LEFT MENU-->
                        <?php require_once 'includes/left-menu.php'; ?>

                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <div class="profile-cont">
                                    <div class="profile-header">
                                        <h3>Michael Alli</h3>
                                        <?php render_view('feeling'); ?>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="creat-post">
                                        <h2>My Reell</h2>
                                        <a class="reat" href="#">+ &nbsp;Create Post</a>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="post-courage">
                                        <h4>Just have courage</h4>
                                        <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/courage-img.png" title="" alt="">
                                        <h5>Yesterday</h5>
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

