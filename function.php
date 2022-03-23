
<?php
if ( ! function_exists( 'electro_off_canvas_nav' ) ) {
    /**
     * Displays Off Canvas Navigation
     */
    function electro_off_canvas_nav() {
        $classes = '';
        if( apply_filters( 'electro_off_canvas_nav_hide_in_desktop', false ) ) {
            $classes = 'off-canvas-hide-in-desktop d-xl-none';
        }
        ?>
        <div class="off-canvas-navigation-wrapper <?php echo esc_attr( $classes ); ?>">
            <div class="off-canvas-navbar-toggle-buttons clearfix">
                <button class="navbar-toggler navbar-toggle-hamburger " type="button">
                    <i class="ec ec-menu"></i>
                </button>
                <button class="navbar-toggler navbar-toggle-close " type="button">
                    <i class="ec ec-close-remove"></i>
                </button>
            </div>

            <div class="off-canvas-navigation<?php if ( ! electro_is_dark_enabled() ): ?> light<?php endif; ?>" id="default-oc-header">
                <!-- <div class="collapse navbar-toggleable-xs" id="default-header"> -->

               <?php
            wp_nav_menu( array(
                'menu'              => 'primary',
                'theme_location'    => 'hand-held-nav',
                'depth'             => 0,
                'container'         => false,
                

                'menu_class'        => 'nav nav-list-inverse nav-list-info',
               
                'fallback_cb'       => 'wp_bootstrap_navwalker3::fallback',
                'walker'			=> new wp_bootstrap_navwalker3(),

            ));
                               
                
                        ?>
                    </div>
                </div>
        <?php
    }
}

?>