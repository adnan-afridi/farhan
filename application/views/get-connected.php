<?php
$this->load->helper('date');
 $curUser = currentuser_session();?>
<div class="center-content">
                            <div id="tabs" class="tabs-inline">
                                <ul class="list-inline nav-tabs">
                                    <li><a href="#recent-activities" role="tab" data-toggle="tab">Recent Activities</a></li>
                                    <li><a href="#Connections">Connections</a></li>
                                   
                                </ul>
                                <!-- Tab panes -->
                                    
                                    <div id="recent-activities">
                                    <div class="conection-profile">
                                     <?php foreach ($recentActivities as $ra) { ?>
                                     <div class="conection-box">
                                     	<div class="conection-image">
			                                        <a href="<?php echo base_url("Posts/view_post?id=".$ra['post_id']); ?>"><img class="img-pp" width="120px" height="121px" src="<?php echo base_url(); ?>assets/images/profile_images/<?php echo ($ra['profile_image']) ? $ra['profile_image'] : 'dummy-img.png'; ?>" alt="" title=""></a>
			                                    </div>
			                                    <div class="conection-name"><?php echo substr($ra['first_name'], 0, 10); ?></div>
                                      </div>
                                    <?php } ?>
                                    </div>
                                    </div>
                                    <div id="Connections">
                                    	<div class="conection-profile">
                                        
                                        	<?php
                                             if ($users) {
                                        	 foreach ($users as $user_info) {?>
			                                <div class="conection-box">
			                                    <div class="conection-image">
			                                        <img class="img-pp" width="120px" height="121px" src="<?php echo $img = (!empty($user_info['profile_image'])) ? base_url()."assets/images/profile_images/".$user_info['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="">
			                                    </div>
			                                    <div class="conection-name"><?php echo $user_info['first_name'].' '.$user_info['last_name']; ?></div>
			                                    <a href="<?php echo base_url()?>pm/send/<?php echo $user_info['user_id']; ?>" class="message-btn">Send Message</a>
			                                </div>
                                            
                                            <?php } }else{?>
                                            <div class="conection-box">
			                                    <span>Friend List is empty</span>
			                                </div>
                                            <?php }?>
			                               
			                            </div>
                                    </div>
                               
                            </div>
                            
                        </div>
