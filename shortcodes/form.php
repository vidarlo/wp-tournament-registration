<?php

/* shortcode for registration form */
function wp_tournreg_get_form( $atts = [], $content = null ) {
		
	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
	$a = shortcode_atts( array(
		'class' => null,
		'css' => null,
		'css_id' => null,
		'tournament_id' => null,
	), $atts );
	
	wp_enqueue_script( 'wptournreg' );
	wp_enqueue_style( 'wptournreg' );
	
	/* error if tournament id is missing */
	if ( empty ( $a[ 'tournament_id' ] ) ) {
		
		return sprintf( __( '%sERROR: Missing %s in shortcode %s!%s', 'wp-tournament-registration' ), '<strong class="wptournreg-error">', '<kbd>tournament_id</kbd>', '<kbd>wptournregform</kbd>', '</strong>' );
	}
	else {
		$tournament = '<input type="hidden" name="tournament_id" value="' . $a[ 'tournament_id' ] . '">';
	}
	
	/* set action URL */
	$action = ' method="POST" action="' . WP_TOURNREG_ACTION_URL . '"';
	
	/* add custom CSS */
	$css = ( empty ( $a{ 'css' } ) ) ? '' : ' style="' . $a{ 'css' } . '"';
	$class = ' class="wptournreg-form' . ( empty ( $a{ 'class' } ) ? '' :  ' ' . $a{ 'class' } ) . '"';
	$id = ( empty ( $a{ 'css_id' } ) ) ? '' : ' id="' . $a{ 'css_id' } . '"';
	
	require_once WP_TOURNREG_HTML_PATH . 'backlink.php';
	
	return "<form$id$class$css$action>$tournament" . do_shortcode( $content, false ) . '<input type="hidden" name="action" value="wptournreg_add_participant"><input type="submit"><input type="reset"></form>' . get_backlink( 'form' );
}

add_shortcode( 'wptournregform', 'wp_tournreg_get_form' );

/* Action hook of registration form */
function wptournreg_add_participant() {	
	
	require_once WP_TOURNREG_DATABASE_PATH.'insert.php';
	
	echo '<html><head></head></html><body>';
	
	if ( wptournreg_insert_data() === 1 ) {
		
		echo sprintf( __( '%sThank you for your registration.%s', 'wp-tournament-registration'), '<strong class="wptournreg-thanks">', '</strong>' );
	}
	else {
		
		echo sprintf( __( '%sRegistration failed!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', '</strong>' );
	}
	echo '</p>';
	require_once WP_TOURNREG_HTML_PATH . 'backbutton.php';
	echo '</body>';
}
add_action( 'admin_post_nopriv_wptournreg_add_participant', 'wptournreg_add_participant' );