<?php
class wp_bootstrap_navwalker3 extends Walker_Nav_Menu {


/**
 * See Walker: start_lvl function.
 *
 * @since 3.0.0
 * @access public
 * @param mixed $output  Passed by reference. Used to append additional content.
 * @param int   $depth (default: 0) Depth of page. Used for padding.
 * @param array $args (default: array()) An array of arguments. See wp_nav_menu.
 * @return void
 */
public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth );
    $output .= "\n$indent<div id=\"nav-sublist\"><ul role=\"menu\" class=\"nav nav-sublist\">\n";
}

/**
 * See Walker: end_lvl function.
 *
 * @access public
 * @param mixed $output Passed by reference. Used to append additional content.
 * @param int   $depth (default: 0) Depth of menu item. Used for padding.
 * @param array $args (default: array()) An array of arguments. See wp_nav_menu.
 * @return void
 */
function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat( "\t", $depth );
    $output .= 0 === $depth ? "$indent</ul>\n" : "$indent</div></ul>\n";
}

/**
 * See Walker: start_el() function.
 *
 * @access public
 * @param mixed $output Passed by reference. Used to append additional content.
 * @param mixed $item Menu item data object.
 * @param int   $depth (default: 0) Depth of menu item. Used for padding.
 * @param array $args (default: array()) Default Arguments.
 * @param int   $id (default: 0) Menu item ID.
 * @return void
 */



//add_filter("wp_nav_menu_objects","max_nav_items",10,2);
public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 2 ) {
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    // Check if the link it disables Disabled, Active or regular menu item.
    if ( stristr( $item->attr_title, 'disabled' ) ) {
        // $output .= $indent . '<li role="presentation" class="disabled">
        // <a name="' . esc_attr( $item->title ) . '">' . esc_attr( $item->title ) . '</a>';


        $output .= $indent . '<li id="saveChanges"  class="disabled" tabindex="0" role="button" aria-pressed="false">
        <a name="' . esc_attr( $item->title ) . '">' . esc_attr( $item->title ) . '</a>';

    } else { $output .= $item->current ? $indent . '<li class="active">' : $indent . '<li>';
    }

    $atts = array();
    $atts['title']  = ! empty( $item->title )	? $item->title	: '';
    $atts['target'] = ! empty( $item->target )	? $item->target	: '';
    $atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';
    $atts['href'] 	= ! empty( $item->url ) 	? $item->url : '';

    // $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
    $atts = apply_filters( 'electro_nav_menu_link_attributes', $atts, $item, $args, $depth ); // backward compatibility
    
    $attributes = '';
    // $item_outputssss=$item;
    // // if($args->theme_location != "hand-held-nav") return $sorted_menu_items;
    // $items = array();
    // foreach($item_outputssss as $itemss){
    // 	if($itemss->menu_item_parent != 0) continue;
    // 	$items[] = $itemss;
    // }
    // $items = array_slice($items,0,8);
    // foreach($item_outputssss as $key=>$one_item){
    // 	if($one_item->menu_item_parent == 0 && !in_array($one_item,$items)){
    // 		unset($item_outputssss[$key]);
    // 	}
    // }
    // $item=;


    foreach ( $atts as $attr => $value ) {
        if ( ! empty( $value ) ) {
            $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
            $attributes .= ' ' . $attr . '="' . $value . '"';
        }
    }

    /*
     * Glyphicons
     * ===========
     * We check to see there is a value in the attr_title property. If the attr_title
     * property is NOT null or divider we apply it as the class name for the glyphicon.
     */
    $item_output = '';
    $outputss = '';

    if ( ! empty( $item->attr_title ) ) {
        $item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
    } else { $item_output .= '<a'. $attributes .'>';
    }

    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;
    
    $outputss .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    // $output="";
    // echo $outputss;
    // $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        $output .=  	$outputss;

}

/**
 * Traverse elements to create list from elements.
 *
 * @access public
 * @since 2.5.0
 * @param mixed $element Data object.
 * @param mixed $children_elements List of elements to continue traversing.
 * @param mixed $max_depth Max depth to traverse.
 * @param mixed $depth Depth of current element.
 * @param mixed $args Arguments.
 * @param mixed $output Passed by reference. Used to append additional content.
 * @return null Null on failure with no changes to parameters.
 */
public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
    if ( ! $element ) {
        return;
    }
    // if ( ! $element->element ) {
    // 	parent::unset_element( $element, $element );
    // }
    // If parent is not current item, don't output children.
    if ( ! $element->current ) {
        parent::unset_children( $element, $children_elements );
    }
    
    // if ( ! $element->$element ) 
    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
}

/**
 * Menu Fallback
 * =============
 * If this function is assigned to the wp_nav_menu's fallback_cb variable
 * and a manu has not been assigned to the theme location in the WordPress
 * menu manager the function with display nothing to a non-logged in user,
 * and will add a link to the WordPress menu manager if logged in as an admin.
 *
 * @param array $args passed from the wp_nav_menu function.
 */

/**
 * Menu Fallback
 * =============
 * If this function is assigned to the wp_nav_menu's fallback_cb variable
 * and a manu has not been assigned to the theme location in the WordPress
 * menu manager the function with display nothing to a non-logged in user,
 * and will add a link to the WordPress menu manager if logged in as an admin.
 *
 * @param array $args passed from the wp_nav_menu function.
 *
 */
public static function fallback( $args ) {
    if ( current_user_can( 'manage_options' ) ) {

        extract( $args );

        $fb_output = null;

        if ( $container ) {
            $fb_output = '<' . $container;

            if ( $container_id )
                $fb_output .= ' id="' . $container_id . '"';

            if ( $container_class )
                $fb_output .= ' class="' . $container_class . '"';

            $fb_output .= '>';
        }

        $fb_output .= '<ul';

        if ( $menu_id )
            $fb_output .= ' id="' . $menu_id . '"';

        if ( $menu_class )
            $fb_output .= ' class="' . $menu_class . '"';

        $fb_output .= '>';
        $fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">' . esc_html__( 'Add a menu', 'electro' ) . '</a></li>';
        $fb_output .= '</ul>';

        if ( $container )
            $fb_output .= '</' . $container . '>';

        echo wp_kses_post( $fb_output );
    }
}
}
?>