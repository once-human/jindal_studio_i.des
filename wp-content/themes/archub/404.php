<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package archub theme
 */

get_header();

$data_content = liquid_helper()->get_option( 'error-404-content', 'post', '', 'options' );

$is_elementor = defined( 'ELEMENTOR_VERSION' );
$classnames = array(
	'page-404',
	'error-404',
	'not-found',
	'entry',
	$is_elementor ? 'elementor' : ''
);

?>
<article id="post-404" class="<?php echo esc_attr(implode(' ', $classnames)) ?>">
	
	<div class="container pt-6 pb-6">
		<div class="row pt-6 pb-6">	
			<div class="col-md-12 text-center">
	
				<div class="text-404">
		
					<h1 class="liquid-counter-element mb-0">
						<!--/.THIS IS NOT TRANSLATABLE OR DYNAMIC THING, IT NEEDS FOR THE EFFECTS -->
						<span>404</span>
					</h1>
	
				</div>
	
				<?php if( !class_exists( 'ReduxFramework' ) ) : ?>

					<h3 class="font-weight-normal mb-3"><?php esc_html_e( 'Looks like you are lost.', 'archub' ); ?></h3>
					<p class="mb-3"><?php esc_html_e( 'We can’t seem to find the page you’re looking for.', 'archub' ) ?></p>					
					<a href="<?php echo esc_url( home_url('/') ) ?>" class="btn elementor-button btn-md ws-nowrap btn-icon-left">
						<span class="btn-txt"><?php esc_html_e( 'Go Home!', 'archub' ); ?></span>
						<span class="btn-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"> <path d="M26.688 14.664H10.456l7.481-7.481L16 5.313 5.312 16 16 26.688l1.87-1.87-7.414-7.482h16.232v-2.672z" fill="currentColor"></path> </svg>
						</span>
					</a>

				<?php else : ?>

					<h3 class="font-weight-normal mb-3"><?php esc_html(liquid_helper()->get_option_echo( 'error-404-subtitle', 'html', '', 'options' )) ?></h3>
					<?php if( !empty( $data_content ) ) : ?>
						<p><?php echo wp_kses( $data_content, 'lqd_post' ); ?></p>
					<?php endif ?>
					<?php if( 'on' === liquid_helper()->get_option( 'error-404-enable-btn', 'raw', '', 'options' ) ) { ?>
						<a href="<?php echo esc_url( home_url('/') ) ?>" class="btn elementor-button ws-nowrap btn-icon-left">
							<span class="btn-txt"><?php esc_html(liquid_helper()->get_option_echo( 'error-404-btn-title', 'html', '', 'options' )) ?></span>
							<span class="btn-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"> <path d="M26.688 14.664H10.456l7.481-7.481L16 5.313 5.312 16 16 26.688l1.87-1.87-7.414-7.482h16.232v-2.672z" fill="currentColor"></path> </svg>
							</span>
						</a>
					<?php } ?>
				<?php endif; ?>
				
			</div>
	
		</div>
	
	</div>
	
</article>

<?php get_footer();