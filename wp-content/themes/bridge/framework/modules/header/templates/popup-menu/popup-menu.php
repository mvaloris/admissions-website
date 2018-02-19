<?php
if($enable_popup_menu == "yes"){ ?>
    <div class="popup_menu_holder_outer">
        <div class="popup_menu_holder">
            <div class="popup_menu_holder_inner">
                <nav class="popup_menu">
					<?php
					wp_nav_menu( array( 'theme_location' => 'popup-navigation' ,
						'container'  => '',
						'container_class' => '',
						'menu_class' => '',
						'menu_id' => '',
						'fallback_cb' => 'top_navigation_fallback',
						'link_before' => '<span>',
						'link_after' => '</span>',
						'walker' => new qode_type3_walker_nav_menu()
					));
					?>
                </nav>
				<?php
				//Sidearea under menu
				if(is_active_sidebar('fullscreen_menu_area_widget')) : ?>
                    <div class="popup_menu_widget_holder"><div>
							<?php dynamic_sidebar('fullscreen_menu_area_widget'); ?>
                        </div></div>
				<?php endif;
				?>
            </div>
        </div>
    </div>
<?php } ?>