

<!-- Start wrapper-->
 <div id="wrapper">

 <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
	<div class="card card-authentication1 mx-auto my-5">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="<?php echo URL; ?>assets/images/logo-icon.png" alt="logo icon">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3"><?php echo _('OSP (S) Login'); ?></div>
                  <form method="post" action="/account/run">
			  <div class="form-group">
			  <label for="exampleInputUsername" class="sr-only"><?php echo _('Username'); ?></label>
			   <div class="position-relative has-icon-right">
				  <input type="text" id="exampleInputUsername" name="username" class="form-control input-shadow" placeholder="<?php echo _('Enter Username'); ?>">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label for="exampleInputPassword" class="sr-only"><?php echo _('Password'); ?></label>
			   <div class="position-relative has-icon-right">
				  <input type="password" id="exampleInputPassword" name="password" class="form-control input-shadow" placeholder="<?php echo _('Enter Password'); ?>">
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
			   </div>
			  </div>
                        
			 <button type="submit" class="btn btn-light btn-block"><?php echo _('Sign In'); ?></button>
			 
			 </form>
		   </div>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	</div><!--wrapper-->
<footer style="align-items:center; text-align: center; position: absolute; bottom: 0; width: 100%;">
    <p>Copyright 2023 by OSP-PHP (S). Alle Rechte vorbehalten.</p>
</footer>