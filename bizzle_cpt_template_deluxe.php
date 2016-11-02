<?php
   /*
   Plugin Name: **Name This Plugin**
   Plugin URI: http://www.bizzledesigns.com
   Description: A Plugin to Add Custom Post Types to any Wordpress website
   Version: 2.0
   Author: Mr. Rob Ruiz
   Author URI: http://www.bizzledesigns.com
   License: GPL2
   */
   
   //Post Type Terms - this is a shortcut for generic situations, some CPTs may call for more specific terminology
   // - in which case replace the these variables with the static string terms inline
   $cpt_sing = 'Presentation';
   $cpt_plural = 'Presentations';
   $category_sing = 'Presentation Category';
   $category_plural = 'Presentation Categories';
   
	//Register the Post Type
	
	//Set all labels to appropriate termanology	
   function create_post_type() {
  $labels = array(
    'name'               => _x( $cpt_sing, 'post type general name' ),
    'singular_name'      => _x( $cpt_sing, 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'my_cpt' ),
    'add_new_item'       => __( 'Add New '.$cpt_sing ),
    'edit_item'          => __( 'Edit '.$cpt_sing ),
    'new_item'           => __( 'New '.$cpt_sing ),
    'all_items'          => __( 'All '.$cpt_plural ),
    'view_item'          => __( 'View '.$cpt_plural ),
    'search_items'       => __( 'Search '.$cpt_plural ),
    'not_found'          => __( 'No '.$cpt_plural.' found' ),
    'not_found_in_trash' => __( 'No '.$cpt_plural.' found in the Trash' ), 
    'parent_item_colon'  => '',
	
    'menu_name'          => $cpt_plural
	
  );
  
  //Supply the list of arguments for the function
  $args = array(
    'labels'        => $labels,
    'description'   => 'Management for All Food & Spirits Magazines Online Issues',
    'public'        => true,
    'menu_position' => 7,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments','custom-fields'),
	'menu_icon' => 'dashicons-book-alt',
    'has_archive'   => 'my_cpt',
	'taxonomies'	=> array('tag'),
  );
  
  //This is where we actually register the post type with the ever so creatively named function
  //You'll want to change my_cpt to something that makes more sense for what you are using the CPTs for (ex. products, events, items, etc.)
  register_post_type( 'my_cpt', $args ); 
}

//Here we are actually adding the action and thus initiallizing the post type creation from within this plugin
add_action( 'init', 'create_post_type' );
  
//Customize Post Type Messages with the filter API
  
  function cpt_messages( $messages ) {
  global $post, $post_ID;
  $messages['my_cpt'] = array(
    0 => '', 
    1 => sprintf( __($cpt_sing.' updated. <a href="%s">View '.$cpt_sing.'</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __($cpt_sing.' updated.'),
    5 => isset($_GET['revision']) ? sprintf( __($cpt_sing.' restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __($cpt_sing.' published. <a href="%s">View '.$cpt_sing.'</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Issue saved.'),
    8 => sprintf( __($cpt_sing.' submitted. <a target="_blank" href="%s">Preview '.$cpt_sing.'</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __($cpt_sing.' scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview '.$cpt_sing.'</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __($cpt_sing.' draft updated. <a target="_blank" href="%s">Preview '.$cpt_sing.'</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'cpt_messages' );

// ======  Register Categories
// ==========================

function add_my_cpt_category() {
  $labels = array(
    'name'              => _x( $category_plural, 'taxonomy general name' ),
    'singular_name'     => _x( $category_sing, 'taxonomy singular name' ),
    'search_items'      => __( 'Search '.$category_plural ),
    'all_items'         => __( 'All '.$category_plural ),
    'parent_item'       => __( 'Parent '.$category_sing ),
    'parent_item_colon' => __( 'Parent '.$category_sing.':' ),
    'edit_item'         => __( 'Edit '.$category_sing ), 
    'update_item'       => __( 'Update '.$category_sing ),
    'add_new_item'      => __( 'Add New '.$category_sing ),
    'new_item_name'     => __( 'New '.$category_sing ),
    'menu_name'         => __( $category_plural ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'my_cpt_category', 'my_cpt', $args );
}
add_action( 'init', 'add_my_cpt_category', 0 );
//============ END Categories =============================

//  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!!!!!!! For Simple CPTs, Just remove or comment everything below here !!!!!!!!!!!!
//  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// =====  create tags for the cpt (optional)
// ========================================
function create_cpt_tags() 
{
// Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Tags' ),
    'popular_items' => __( 'Popular Tags' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Tag' ), 
    'update_item' => __( 'Update Tag' ),
    'add_new_item' => __( 'Add New Tag' ),
    'new_item_name' => __( 'New Tag Name' ),
    'separate_items_with_commas' => __( 'Separate tags with commas' ),
    'add_or_remove_items' => __( 'Add or remove tags' ),
    'choose_from_most_used' => __( 'Choose from the most used tags' ),
    'menu_name' => __( 'Tags' ),
  ); 

  register_taxonomy('tag','fsm_issues',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tag' ),
  ));
}

add_action( 'init', 'create_issue_tags', 0 ); 

// =================== END Tags =========================


//======== Admin Menu Customizations - for listing your CPT ====

// ====  Create Columns Tags and Categories in backend
// =======================================================

add_filter( 'manage_edit-fsm_issues_columns', 'fsm_edit_issues_columns' ) ;

function fsm_edit_issues_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Issue #' ),
		'issue_name' => __( 'Issue Name' ),
		'issue_preview' => __('Preview'),
		'date' => __( 'Date' )
	);
	/**
	Removed columns
		'customer_email'=> __( 'Customer Email' ),
		'sales_rep'=> __( 'Sales Rep' ),
		'artist'=> __( 'Artist' ),
	*/
	return $columns;
}

add_action( 'manage_fsm_issues_posts_custom_column', 'fsm_manage_issues_columns', 10, 2 );

 function fsm_manage_issues_columns( $column, $post_id ) {
	global $post;
	global $wpdb;
	switch( $column ) {
		
		/* If displaying the 'Issue Name' column. */
		case 'issue_name' :
		$issue_name = get_post_meta( $post_id, 'issue_name', true );
		if ( empty( $issue_name ) )
				echo  __( 'No Issue Name Assigned' );

			/* If there is an issue name, show it. */
			else
				echo __( $issue_name );
		break;
			
		//If Displaying the Issue Preview
		case 'issue_preview' :
			
			$the_thumb = get_the_post_thumbnail( $post_id, 'thumbnail' );
			
			if ( empty( $the_thumb ) )
				echo  __( 'No Image' );

			else
				
				echo __( $the_thumb );

			break;
		
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
} 


// ================= END ==================================== 

/*function art_proofs_enqueue_scripts( $hook ) {

    if( !in_array( $hook, array( 'edit.php') ) )
        return;

    wp_enqueue_script( 
        'your_script_handle',                         // Handle
        plugins_url( '/style-proofs-listing.js', __FILE__ ),  // Path to file
        array( 'jquery' )                             // Dependancies
    );
}
add_action( 'admin_enqueue_scripts', 'art_proofs_enqueue_scripts', 2000 );*/

//Send out emails when a CPT is published
/*function proof_publish_send_email( $post ) {
// lets check the post type and only do it for Art Proofs
	$current_post_type = $post->post_type;
	$ID = $post->ID;
	if ($current_post_type == "art_proofs"){
		$message = '<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#ffffff">';
		
		wp_mail($email_recipient, $subject, $message );
		}
	}
}
add_action( 'draft_to_publish', 'proof_publish_send_email', 10, 1 );*/

//Enqueue Custom Scripts (CSS or JS) on Admin or CPT related pages
/*add_action( 'admin_enqueue_scripts', 'html2canvas_enqueue_scripts', 2000 );
function html2canvas_enqueue_scripts( $hook ) {
	wp_enqueue_script( 'html2canvas','/js/html2canvas.js', array('jquery'), '', true );
}*/

//Register Custom Shortcode
/*function hsi_artist_img( $atts ){
	return '<div class="artist-img"></div>';
}
add_shortcode( 'artist_image', 'hsi_artist_img' );

/**
 * Creating a Custom meta box!!!!
 */
function call_someClass() 
{
    return new someClass();
}
if ( is_admin() )
    add_action( 'load-post.php', 'call_someClass' );

/** 
 * The Class
 */
class someClass
{
    const LANG = 'some_textdomain';

    public function __construct()
    {
        add_action( 'add_meta_boxes', array( &$this, 'add_some_meta_box' ) );
    }

    /**
     * Adds the meta box container
     */
    public function add_some_meta_box()
    {
        add_meta_box( 
             'some_meta_box_name'
            ,__( 'Proof Preview on Product', self::LANG )
            ,array( &$this, 'render_meta_box_content' )
            ,'art_proofs' 
            ,'advanced'
            ,'high'
        );
    }


    /**
     * Render Meta Box content
     */
    public function render_meta_box_content() {
         
		//Add HTML for Meta Box here (or script tags for JS or whatever
		
	}  
}



?>