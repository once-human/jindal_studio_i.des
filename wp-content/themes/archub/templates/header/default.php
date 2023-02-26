<?php

/**
* Default header
*
* @package Hub
*/

?>
<header class="main-header lqd-main-header-default">

	<div class="lqd-head-sec-wrap pos-rel">

		<div class="lqd-head-sec container-fluid d-flex align-items-center ps-4 pe-4">

				<div class="elementor-widget-wrap d-flex w-30">

					<div class="elementor-element d-flex module-logo pt-4 pb-4 w-auto">

						<a class="navbar-brand d-flex pos-rel p-0" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<span class="navbar-brand-inner">
								<img class="logo-default" src="<?php liquid_logo_url(); ?>" alt="<?php echo bloginfo( 'name' ) ?>" />
							</span>
						</a>

					</div>
					
				</div>

				<div class="elementor-widget-wrap d-flex justify-content-end flex-grow-1">

					<div class="elementor-element d-flex pt-0 pb-0 w-auto">

						<div class="navbar-collapse" id="main-header-collapse" aria-expanded="false" role="navigation">
							<?php

								if( has_nav_menu( 'primary' ) ) :

									wp_nav_menu( array(
										'theme_location' => 'primary',
										'container'      => 'ul',
										'before'         => false,
										'after'          => false,
										'link_before'    => '',
										'link_after'     => '<span class="submenu-expander"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path></svg></span>',
										'menu_id'        => 'primary-nav',
										'menu_class'     => 'main-nav nav d-flex reset-ul inline-nav main-nav-hover-underline ps-0 pe-0',
										'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
										'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new Liquid_Mega_Menu_Walker : '',
									) );

								else:

									wp_nav_menu( array(
										'container'      => 'ul',
										'before'         => false,
										'after'          => false,
										'link_before'    => '',
										'link_after'     => '<span class="submenu-expander"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path></svg></span>',
										'menu_id'        => 'primary-nav',
										'menu_class'     => 'main-nav nav d-flex reset-ul inline-nav main-nav-hover-underline ps-0 pe-0',
										'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
										'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new Liquid_Mega_Menu_Walker : '',
									) );

								endif;

							?>
						</div>

						</div>
						
						<div class="elementor-element d-flex w-auto">
		
							<?php get_template_part( 'templates/header/header', 'search-default' ); ?>
							
						</div>

				</div>

		</div>
	
	</div>

	<div class="lqd-mobile-sec pos-rel">

		<div class="lqd-mobile-sec-inner navbar-header d-flex align-items-stretch w-100">

			<div class="lqd-mobile-modules-container empty"></div>

			<button
			type="button"
			class="navbar-toggle collapsed nav-trigger style-1 d-flex pos-rel align-items-center justify-content-center"
			data-ld-toggle="true"
			data-toggle="collapse"
			data-target="#lqd-mobile-sec-nav"
			aria-expanded="false"
			data-toggle-options='{ "changeClassnames": {"html": "mobile-nav-activated"} }'>
				<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'archub' ); ?></span>
				<span class="bars d-inline-block pos-rel z-index-1">
					<span class="bars-inner d-flex flex-column w-100 h-100">
						<span class="bar d-inline-block pos-rel"></span>
						<span class="bar d-inline-block pos-rel"></span>
						<span class="bar d-inline-block pos-rel"></span>
					</span>
				</span>
			</button>

			<a class="navbar-brand d-flex pos-rel" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="navbar-brand-inner">
					<img class="logo-default" src="<?php liquid_logo_url(); ?>" alt="<?php echo bloginfo( 'name' ) ?>" />
				</span>
			</a>

		</div>

		<div class="lqd-mobile-sec-nav w-100 pos-abs z-index-10">
			<div class="collapse navbar-collapse w-100" id="lqd-mobile-sec-nav" aria-expanded="false" role="navigation">

				<?php
			
					if( has_nav_menu( 'primary' ) ) :

						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container'      => 'ul',
							'before'         => false,
							'after'          => false,
							'link_before'    => '',
							'link_after'     => '<span class="submenu-expander"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path></svg></span>',
							'menu_id'        => 'mobile-primary-nav',
							'menu_class'     => 'mobile-main-nav main-nav reset-ul ps-2 pe-0',
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new Liquid_Mega_Menu_Walker : '',
						) );

					else:

						wp_nav_menu( array(
							'container'   => 'ul',
							'before'      => false,
							'after'       => false,
							'link_before' => '',
							'link_after'  => '<span class="submenu-expander"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path></svg></span>',
							'menu_id'     => 'mobile-primary-nav',
							'menu_class'  => 'mobile-main-nav main-nav reset-ul ps-2 pe-0',
							'depth'       => 3,
							'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new Liquid_Mega_Menu_Walker : '',
						) );

					endif;

				?>

			</div>
		</div>

	</div>

</header>