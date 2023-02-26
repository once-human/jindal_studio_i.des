<?php

extract( $atts );

// classes
$classes = array( 
	'lqd-gdpr',
		
	$el_class, 
	$this->get_id() 
);

$this->generate_css();

?>
<div id="lqd-gdpr" class="<?php echo $this->sanitize_html_classes( $classes ) ?>">
	<div class="lqd-gdpr-inner">
		<div class="lqd-gdpr-left">
			<?php echo do_shortcode( $content ); ?>
		</div><!-- /.lqd-gdpr-left -->
		<div class="lqd-gdpr-right">
			<button class="lqd-gdpr-accept"><?php echo do_shortcode( $accept_text ); ?></button>
		</div><!-- /.lqd-gdpr-right -->
	</div><!-- /.lqd-gdpr-inner -->
</div><!-- /.lqd-gdpr -->