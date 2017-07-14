<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($assesmentData);exit;
$curUser = currentuser_session();
?>

<!--Content-->
<div class="content">
    <div class="container">

        <div class="row">

            <div class="col-lg-12">
                <div class="row">
                    <div class="profile get-connected">
                        <!--left menu-->
                        <?php
                        if ($assesment != 0) {
                            require_once 'includes/left-menu.php';
                        }
                        else {
                            echo '<div class="col-sm-1"></div>';
                        }
                        ?>
                        <div class="col-md-9 col-sm-8">
                            <div class="assesment">
                                <h2>Setting</h2>

                                <div class="assesment-inner">
                                <?php if(validation_errors()!='')
								{?>
									<?php echo validation_errors();?>
									
									
								<?php }?>
                                
                                <?php if($this->session->userdata('sessionMessage')!='')
								{?>
									<p><?php echo $this->session->userdata('sessionMessage');
									$this->session->unset_userdata('sessionMessage');?>
									</p>
								<?php }?>

                                    <form method="post" id="assesment-form" action="" enctype="multipart/form-data">
                                        <div class="col-sm-4">
                                            <input type="password"  name="old_password" placeholder="Old Password" class="form-control" value=""/>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="password"  name="new_password" placeholder="New Password" class="form-control" value=""/>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="password"  name="con_password" placeholder="Confirm Password" class="form-control" value=""/>
                                            
                                        </div>
                                        <div class="clear"></div>

                                        <div class="option-wrap">
                                            
                                            <div class="col-sm-4 marginTop10">
                                                <select class="form-control" id="user_status" name="user_status">
                                                <option value="1">Activate</option>
                                                <option value="0">Deactivate</option>
                                               
                                            </select>
                                            </div>
                                            <div class="clearfix"></div>
                                            
                                            
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="asses-btn marginTop10">
                                            <?php if ($assesment == 0) { ?>
                                                <div><a  href="<?php echo base_url('Logout'); ?>"><button type="button">Logout</button></a></div>
                                            <?php } ?>
                                            <button type="submit">Submit</button>
                                            <div class="clear"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

