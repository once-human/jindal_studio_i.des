<?php
	
	$register = new Liquid_Register;

?>
<div class="lqd-dsd-box lqd-dsd-box-solid lqd-dsd-register-box">

	<div class="lqd-dsd-box-head">
		
		<?php $register->messages(); ?>

	</div>

	<?php $register->form(); ?>

</div>