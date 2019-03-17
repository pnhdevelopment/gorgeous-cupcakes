<?php
/*
*	REGISTER NAV MENU
*/
function register_my_menus() {
 register_nav_menus(
 array( 'header-menu' => __( 'Header Menu' ) )
 );
 }
add_action( 'init', 'register_my_menus' );


/*
*	ENABLE LOGO UPLOAD
*/
function gorgeous_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'gorgeous_logo' ); // Add setting for logo uploader
         
    // Add control for logo uploader (actual uploader)
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'gorgeous_logo', array(
        'label'    => __( 'Upload Logo', 'gorgeous' ),
        'section'  => 'title_tagline',
        'settings' => 'gorgeous_logo',
    ) ) );
}
add_action( 'customize_register', 'gorgeous_customize_register' );


/*
*	GLOBAL CUSTOM OPTIONS
*/
add_action('admin_menu', 'add_global_custom_options');

function add_global_custom_options()
{
    add_options_page('Global Custom Options', 'Global Custom Options', 'manage_options', 'functions','global_custom_options');
}

function global_custom_options()
{
?>
    <div class="wrap">
        <h2>Global Custom Options</h2>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options') ?>

            <table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="contact_number">Contact Number</label></th>
						<td><input type="text" id="contact_number" name="contact_number" size="45" value="<?php echo get_option('contact_number'); ?>" /></td>
					</tr>

					<tr>
						<th scope="row"><label for="pickups">Pickups Text</label></th>
						<td><textarea id="pickups" name="pickups" cols="100%" rows="7"><?php echo get_option('pickups'); ?></textarea></td>
					</tr>

					<tr>
						<th scope="row"><label for="deliveries">Deliveries Text</label></th>
						<td><textarea id="deliveries" name="deliveries" cols="100%" rows="7"><?php echo get_option('deliveries'); ?></textarea></td>
					</tr>
				</tbody>
			</table>

            <p><input type="submit" name="Submit" class="button button-primary" value="Save Changes" /></p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="contact_number,pickups,deliveries" />
        </form>
    </div>
<?php
}

/*
* ENABLE POST TUMBNAIL SUPPORT
*/
add_theme_support( 'post-thumbnails' );


/*
* REGISTERS 'CUPCAKES' POST TYPE AND TAXONOMY 
*/

function wp_cupcake_posttype() {
	register_post_type( 'cupcakes',
		array(
			'labels' => array(
				'name' => __( 'Cupcakes' ),
				'singular_name' => __( 'Cupcake' ),
				'add_new' => __( 'Add New Cupcake' ),
				'add_new_item' => __( 'Add New Cupcake' ),
				'edit_item' => __( 'Edit Cupcake' ),
				'new_item' => __( 'Add New Cupcake' ),
				'view_item' => __( 'View Cupcake' ),
				'search_items' => __( 'Search Cupcake' ),
				'not_found' => __( 'No cupcakes found' ),
				'not_found_in_trash' => __( 'No cupcakes found in trash' )
			),
			'public' => true,
			'supports' => array( 'title', 'editor', 'thumbnail', 'comments' ),
			'capability_type' => 'post',
			'rewrite' => array("slug" => "cupcakes"), // Permalinks format
			'menu_position' => 5,
            'menu_icon'   => 'dashicons-universal-access-alt',
			'register_meta_box_cb' => 'add_cupcakes_metaboxes'
		)
	);
}
add_action( 'init', 'wp_cupcake_posttype' );

function my_taxonomies_product() {
  $labels = array(
    'name'              => _x( 'Cupcake Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Cupcake Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Cupcake Categories' ),
    'all_items'         => __( 'All Cupcake Categories' ),
    'parent_item'       => __( 'Parent Cupcake Category' ),
    'parent_item_colon' => __( 'Parent Cupcake Category:' ),
    'edit_item'         => __( 'Edit Cupcake Category' ), 
    'update_item'       => __( 'Update Cupcake Category' ),
    'add_new_item'      => __( 'Add New Cupcake Category' ),
    'new_item_name'     => __( 'New Cupcake Category' ),
    'menu_name'         => __( 'Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'cupcakes_category', 'cupcakes', $args );
}
add_action( 'init', 'my_taxonomies_product', 0 );


/*
* REGISTER 'PRICE' META BOX FOR CUPCAKES POST TYPE
*/

// Add the Price Meta Box
function add_cupcakes_metaboxes() {
	add_meta_box('wpt_cupcakes_price', 'Cupcake Price', 'wpt_cupcakes_price', 'cupcakes', 'side', 'default');
}
add_action( 'add_meta_boxes', 'add_cupcakes_metaboxes' );

function wpt_cupcakes_price() {
	global $post;
	
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="cupcakemeta_noncename" id="cupcakemeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the price data if its already been entered
	$price = get_post_meta($post->ID, '_price', true);
	
	// Echo out the field
	echo '<input type="text" name="_price" value="' . $price  . '" class="widefat" />';

}

// Save the Metabox Data
function wpt_save_cupcakes_meta($post_id, $post) {
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['cupcakemeta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	
	$events_meta['_price'] = $_POST['_price'];
	
	// Add values of $events_meta as custom fields
	
	foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}

}
add_action('save_post', 'wpt_save_cupcakes_meta', 1, 2); // save the custom fields


/*
* REGISTER IMAGE ATTACHMENTS FOR CUPCAKES POST TYPE (USES 'ATTACHMENTS' PLUGIN)
*/
function my_attachments( $attachments )
{
  $fields         = array(
    array(
      'name'      => 'title',                         // unique field name
      'type'      => 'text',                          // registered field type
      'label'     => __( 'Title', 'attachments' ),    // label to display
      'default'   => 'title',                         // default value upon selection
    )
  );

  $args = array(

    // title of the meta box (string)
    'label'         => 'My Attachments',

    // all post types to utilize (string|array)
    'post_type'     => array( 'cupcakes' ),

    // meta box position (string) (normal, side or advanced)
    'position'      => 'normal',

    // meta box priority (string) (high, default, low, core)
    'priority'      => 'high',

    // allowed file type(s) (array) (image|video|text|audio|application)
    'filetype'      => null,  // no filetype limit

    // include a note within the meta box (string)
    'note'          => 'Attach files here!',

    // by default new Attachments will be appended to the list
    // but you can have then prepend if you set this to false
    'append'        => true,

    // text for 'Attach' button in meta box (string)
    'button_text'   => __( 'Attach Files', 'attachments' ),

    // text for modal 'Attach' button (string)
    'modal_text'    => __( 'Attach', 'attachments' ),

    // which tab should be the default in the modal (string) (browse|upload)
    'router'        => 'browse',

    // whether Attachments should set 'Uploaded to' (if not already set)
    'post_parent'   => false,

    // fields array
    'fields'        => $fields,

  );

  $attachments->register( 'my_attachments', $args ); // unique instance name
}

add_action( 'attachments_register', 'my_attachments' );


/*
* SLIDESHOW POST TYPE FOR HOMEPAGE SLIDER
*/
register_post_type('slideshow', array(
    'label' => 'Slideshow',
    'show_ui' => true,
    'supports' => array('title'),
    'labels' => array (
        'name' => 'Slideshow',
        'singular_name' => 'Slideshow',
        'menu_name' => 'Slideshow',
    ),
    'menu_icon'   => 'dashicons-format-gallery',
    'supports' => array( 'title','thumbnail' )
) );



/*
* FEATURED CUPCAKE META BOX
*/

/**
 * Adds a meta box to the post editing screen
 */
function prfx_featured_meta() {
    add_meta_box( 'prfx_meta', __( 'Featured Cupcakes', 'prfx-textdomain' ), 'prfx_meta_callback', 'cupcakes', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'prfx_featured_meta' );
 
/**
 * Outputs the content of the meta box
 */
 
function prfx_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>
 
 <p>
    <span class="prfx-row-title"><?php _e( 'Check if this is a featured post: ', 'prfx-textdomain' )?></span>
    <div class="prfx-row-content">
        <label for="featured-checkbox">
            <input type="checkbox" name="featured-checkbox" id="featured-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['featured-checkbox'] ) ) checked( $prfx_stored_meta['featured-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Featured Item', 'prfx-textdomain' )?>
        </label>
 
    </div>
</p>   
 
    <?php
}
 
/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
    // Checks save status - overcome autosave, etc.
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
// Checks for input and saves - save checked as yes and unchecked at no
if( isset( $_POST[ 'featured-checkbox' ] ) ) {
    update_post_meta( $post_id, 'featured-checkbox', 'yes' );
} else {
    update_post_meta( $post_id, 'featured-checkbox', 'no' );
}
 
}
add_action( 'save_post', 'prfx_meta_save' );


/*
* ENQUEUE CSS + JAVASCRIPT
*/

function theme_name_scripts() {
  wp_enqueue_style( 'style-bootstrap', "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" );
  wp_enqueue_style( 'style-slick', get_template_directory_uri() . '/assets/slick.css' );
  wp_enqueue_style( 'style-main', get_stylesheet_uri() );
  wp_enqueue_style( 'style-magnific', get_template_directory_uri().'/assets/magnific.css');
  wp_enqueue_style( 'fontawesome', 'http:////maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'google-font-PT-Sans', 'http:////fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic' );
  wp_enqueue_style( 'google-font-Pacifi', 'http:////fonts.googleapis.com/css?family=Pacifico' );

  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'script-bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');
  wp_enqueue_script( 'script-slick', get_template_directory_uri() . '/assets/slick.js' );
  wp_enqueue_script( 'script-magnific', get_template_directory_uri() . '/assets/magnific.js' );
  wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/script.js', true );

}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );



/* ENABLE SHORTCODE IN WIDGET TEXT */
add_filter('widget_text', 'do_shortcode');

/*
* CONTACT US FORM WIDGET
*/
function contact_us_form_widgets_init() {

    register_sidebar( array(
        'name'          => 'Contact Us Form',
        'id'            => 'contact_us',
        'before_widget' => '<div>',
        'after_widget'  => '</div>'
    ) );

}
add_action( 'widgets_init', 'contact_us_form_widgets_init' );

/*
* FOOTER WIDGET AREA
*/
function footer_widgets_init() {
 
    // First footer widget area, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'First Footer Widget Area'),
        'id' => 'first-footer-widget-area',
        'description' => __( 'The first footer widget area'),
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ) );
 
    // Second Footer Widget Area, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Second Footer Widget Area'),
        'id' => 'second-footer-widget-area',
        'description' => __( 'The second footer widget area'),
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ) );
 
    // Third Footer Widget Area, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Third Footer Widget Area'),
        'id' => 'third-footer-widget-area',
        'description' => __( 'The third footer widget area'),
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ) );
 
    // Fourth Footer Widget Area, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Fourth Footer Widget Area'),
        'id' => 'fourth-footer-widget-area',
        'description' => __( 'The fourth footer widget area'),
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ) );
         
}
 
// Register sidebars by running tutsplus_widgets_init() on the widgets_init hook.
add_action( 'widgets_init', 'footer_widgets_init' );

function shopping_cart_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Shopping Cart Widget Area'),
        'id' => 'shopping-cart-widget-area',
        'description' => __( 'The shopping cart widget area'),
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h1><span>',
        'after_title' => '</h1></span>',
    ) );
}

add_action( 'widgets_init', 'shopping_cart_widgets_init' );


function dashboard_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Dashboard'),
        'id' => 'dashboard-widget-area',
        'description' => __( 'The dashbaord widget area'),
        'before_widget' => '<div class="dashboard">',
        'after_widget' => '</div>'
    ) );
}

add_action( 'widgets_init', 'dashboard_widgets_init' );


?>

