<div class="center-content">
    <div class="map-cont">
    
    <form name="inspiration" action="" method="post" enctype="multipart/form-data">
    
    <?php
	
    	foreach($quotes as $intKey=>$objQuote){?>
         		  <h5><?php echo $objQuote->title?></h5>
                  
                  
                  
                  <img src="<?php echo $objQuote->background?>" alt="" title="">
				  <h4><?php echo $objQuote->quote?></h4>
                  <input type="hidden" name="background" value="<?php echo $objQuote->background?>" />
                  <input type="hidden" name="quote" value="<?php echo $objQuote->quote?>" />
                  
                  <input type="submit" value="share on wall" name="share" />
                  
        <?php }?>
        
        </form>
    </div>
</div>