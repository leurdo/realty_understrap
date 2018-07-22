<?php
//Setup
load_theme_textdomain( 'rlt', get_template_directory() . '/languages' );

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();

    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
	add_editor_style( get_stylesheet_directory_uri() . '/css/child-theme.min.css' );
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
}

/******************************************************************************************************
 * Filter the except length to 20 characters.
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
******************************************************************************************************/
function wpdocs_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

// Register Realty Custom Post Type
function rlt_create_realty_cpt() {

	$labels = array(
		'name'                  => _x( 'Объекты', 'Post Type General Name', 'rlt' ),
		'singular_name'         => _x( 'Объект', 'Post Type Singular Name', 'rlt' ),
		'menu_name'             => __( 'Недвижимость', 'rlt' ),
		'name_admin_bar'        => __( 'Недвижимость', 'rlt' ),
		'archives'              => __( 'Item Archives', 'rlt' ),
		'attributes'            => __( 'Item Attributes', 'rlt' ),
		'parent_item_colon'     => __( 'Parent Item:', 'rlt' ),
		'all_items'             => __( 'Все объекты', 'rlt' ),
		'add_new_item'          => __( 'Add New Item', 'rlt' ),
		'add_new'               => __( 'Добавить объект', 'rlt' ),
		'new_item'              => __( 'Новый объект', 'rlt' ),
		'edit_item'             => __( 'Редактировать объект', 'rlt' ),
		'update_item'           => __( 'Обновить объект', 'rlt' ),
		'view_item'             => __( 'View Item', 'rlt' ),
		'view_items'            => __( 'View Items', 'rlt' ),
		'search_items'          => __( 'Search Item', 'rlt' ),
		'not_found'             => __( 'Not found', 'rlt' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rlt' ),
		'insert_into_item'      => __( 'Insert into item', 'rlt' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'rlt' ),
		'items_list'            => __( 'Items list', 'rlt' ),
		'items_list_navigation' => __( 'Items list navigation', 'rlt' ),
		'filter_items_list'     => __( 'Filter items list', 'rlt' ),
	);
	$args = array(
		'label'                 => __( 'realty', 'rlt' ),
		'description'           => __( 'Post Type Description', 'rlt' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'realty_type', 'realty_place' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'realty', $args );

}
add_action( 'init', 'rlt_create_realty_cpt', 0 );

// Register Realty Type Custom Taxonomy
function rlt_custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Тип', 'Taxonomy General Name', 'rlt' ),
		'singular_name'              => _x( 'Тип', 'Taxonomy Singular Name', 'rlt' ),
		'menu_name'                  => __( 'Типы', 'rlt' ),
		'all_items'                  => __( 'Типы', 'rlt' ),
		'parent_item'                => __( 'Parent Item', 'rlt' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rlt' ),
		'new_item_name'              => __( 'Имя нового типа', 'rlt' ),
		'add_new_item'               => __( 'Добавить новый тип', 'rlt' ),
		'edit_item'                  => __( 'Редактировать тип', 'rlt' ),
		'update_item'                => __( 'Обновить тип', 'rlt' ),
		'view_item'                  => __( 'Смотреть тип', 'rlt' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rlt' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rlt' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rlt' ),
		'popular_items'              => __( 'Popular Items', 'rlt' ),
		'search_items'               => __( 'Search Items', 'rlt' ),
		'not_found'                  => __( 'Not Found', 'rlt' ),
		'no_terms'                   => __( 'No items', 'rlt' ),
		'items_list'                 => __( 'Items list', 'rlt' ),
		'items_list_navigation'      => __( 'Items list navigation', 'rlt' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'realty_type', array( 'realty' ), $args );

	$labels = array(
		'name'                       => _x( 'Город', 'Taxonomy General Name', 'rlt' ),
		'singular_name'              => _x( 'Город', 'Taxonomy Singular Name', 'rlt' ),
		'menu_name'                  => __( 'Города', 'rlt' ),
		'all_items'                  => __( 'Все города', 'rlt' ),
		'parent_item'                => __( 'Parent Item', 'rlt' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rlt' ),
		'new_item_name'              => __( 'Имя города', 'rlt' ),
		'add_new_item'               => __( 'Добавить новый город', 'rlt' ),
		'edit_item'                  => __( 'Редактировать город', 'rlt' ),
		'update_item'                => __( 'Обновить город', 'rlt' ),
		'view_item'                  => __( 'Смотреть город', 'rlt' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rlt' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rlt' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rlt' ),
		'popular_items'              => __( 'Popular Items', 'rlt' ),
		'search_items'               => __( 'Search Items', 'rlt' ),
		'not_found'                  => __( 'Not Found', 'rlt' ),
		'no_terms'                   => __( 'No items', 'rlt' ),
		'items_list'                 => __( 'Items list', 'rlt' ),
		'items_list_navigation'      => __( 'Items list navigation', 'rlt' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'realty_place', array( 'realty' ), $args );

}
add_action( 'init', 'rlt_custom_taxonomy', 0 );

/**
 * Linebreak helper
 * @return string
 */
function lineToParagraph($string, $class = '')
{
	$output = '';
	$list = preg_split("/\\r\\n|\\r|\\n/", $string);
	foreach ($list as $item) {
		$class_output = ($class ? 'class="' . $class . '"' : '');
		$output .= sprintf('<p %2$s>%1$s</p>', $item, $class_output);
	}

	return $output;
}

//Add all the cities as dropdown to "Cities" primary menu item
function rlt_add_cities( $items )
{
	$locations = get_nav_menu_locations();
	if ( ! is_admin() && isset( $locations['primary'] ) ) {

		//Finding "Cities" menu item
		foreach ( $items as $item ) {
			if ( $item->title == 'Города' ) {
				$parent = $item->ID;
			}
		}

		if ( !empty( $parent ) ) {
			// Adding cities list as children of Cities menu item
			$cities = get_terms( array(
				'taxonomy'    => 'realty_place',
			) );
			foreach ( $cities as $city ) {
				$item = new WP_Post( new stdClass() );

				$item->title = $city->name;
				$item->url   = get_term_link( $city, 'realty_place' );

				$item->db_id     = $city->term_id;
				$item->object_id = $city->term_id;
				$item->object    = $city->taxonomy;
				$item->type      = 'taxonomy';
				$item->menu_item_parent = $parent;

				$item->target      = '';
				$item->attr_title  = '';
				$item->description = '';
				$item->classes     = [];
				$item->xfn         = '';

				$items[] = $item;
			}

			array_map( function ( $item_menu ) {
				static $index = 0;
				$item_menu->menu_order = ++ $index;

				return $item_menu;
			}, $items );
		}
	}

	return $items;
}
add_filter( 'wp_get_nav_menu_items', 'rlt_add_cities' );