//Lets enqueue the scripts that will trigger our POST to the AJAX API
function enqueue_ajax_scripts() {

	if ( /* Some condition so you only enqueue scripts where you need them! */ ) {
	  wp_enqueue_script( 'javascript-file', plugins_url() . '/your_plugin/js/ajax.js', array('jquery'), '', true );
	  wp_localize_script( 'javascript-file', 'hsiajaxloginreg', 
      			array(
					'ajaxurl' 	=> 	admin_url('admin-ajax.php'),
                    'nonce'		=> 	wp_create_nonce('ajax-nonce')
				) 
      );
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_ajax_scripts',99 );

// - NOW - 
//Dynamic Variables built into WP for AJAX actions
add_action( 'wp_ajax_our_ajax_action', 'ajax_callback' );
add_action( 'wp_ajax_nopriv_our_ajax_action', 'ajax_callback' );


function ajax_callback() {
	$userData = $_POST['userData'];
	if ( ! wp_verify_nonce( $_POST['nonce'];, 'ajax-nonce' ) )
	die ( 'Busted!')
	$response['status'] = 'success';
    /*
    	This is where we do whatever we want in PHP
        - affect the database
        - GET or SET data
        - Do just about anthing
    */
	
	$response['data'] = $data;
	$response['message'] = "We Did IT!";
	header( 'Content: application/json' );
	echo json_encode( $response );
	die;
}  