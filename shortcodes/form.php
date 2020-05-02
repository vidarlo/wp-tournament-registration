<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* shortcode for registration form */
function wptournreg_get_form( $atts = [], $content = null ) {
		
	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
	$a = shortcode_atts( array(
		'backlink' => null,
		'class' => null,
		'css' => null,
		'css_id' => null,
		'email' => null,
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
	
	/* Honeypot */
	$noscript = '<noscript><label>' .   __( 'Enable JavaScript!' ) . '<input type="url" name="url" placeholder="' . get_home_url()  .  '"></label></noscript>';
	
	/* E-mail */
	$email = ( empty ( $a[ 'email' ] ) ) ? '' : '<input type="hidden" name="cc" value="' . trim( $a[ 'email' ] ) . '">';
	
	/* set action URL */
	$action = ' method="POST" action="' . WP_TOURNREG_ACTION_URL . '"';
	
	/* add custom CSS */
	$css = ( empty ( $a{ 'css' } ) ) ? '' : ' style="' . trim ( $a[ 'css' ] ) . '"';
	$class = ' class="wptournreg-form' . ( empty ( $a[ 'class' ] ) ? '' :  ' ' . trim( $a[ 'class' ] ) ) . '"';
	$id = ( empty ( $a{ 'css_id' } ) ) ? '' : ' id="' . trim( $a[ 'css_id' ] ) . '"';
	
	$backlink = '';
	if ( !empty ( $a{ 'backlink' } ) ) {
		require_once WP_TOURNREG_HTML_PATH . 'backlink.php';
		$backlink = wptournreg_get_backlink( 'form' );
	}
	
	return "<form$id$class$css$action>$noscript$tournament" . do_shortcode( $content, false ) . '<input type="hidden" name="action" value="wptournreg_add_participant"><input type="submit"><input type="reset"></form>' . $backlink;
}

add_shortcode( 'wptournregform', 'wptournreg_get_form' );

/* Action hook of registration form */
function wptournreg_add_participant() {	
	
	require_once WP_TOURNREG_DATABASE_PATH.'insert.php';
	
	echo '<html><head></head><body><header style="min-height:50px"></header>';
	
	if ( !array_key_exists( 'url', $_POST ) ) {
		
		if ( wptournreg_insert_data() === 1 ) {
			
			printf( __( '%sThank you for your registration.%s', 'wp-tournament-registration'), '<strong class="wptournreg-thanks">', '</strong>' );
			
			/* send E-mail notification */
			if ( array_key_exists( 'cc', $_POST ) ) {
				
				require_once WP_TOURNREG_DATABASE_PATH . 'escape.php';
				$addressee = preg_split( '/\s*,\s*/', wptournreg_escape( $_POST[ 'cc' ] ) );
				$to =[];
				
				foreach ( $addressee as $email ) {
					
					$user = get_user_by( 'login', $addressee );
					if ( $user !== false ) {
						
						$to[] = $user->user_email;
					}
				}

				if ( count( $to ) > 0 ) {
					
					foreach ( $_POST as $key => $value ) {
						
						if ( strcmp( $key, 'action' ) != 0 ) {
							
							$mailbody .= "\n" . strtoupper( $key ) . ': ' . $value;
						} 
					}
					
					wp_mail( $to, __('New participant'), $mailbody );
				}
			}
		}
		else {
			
			printf( __( '%sRegistration failed!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', '</strong>' );
		}
	}
	else {
			
		 printf( __( '%sRegistration failed!%s', 'wp-tournament-registration'), '<strong class="wptournreg-error">', '</strong>' );
	}
	
	echo '</p>';
	require_once WP_TOURNREG_HTML_PATH . 'backbutton.php';
	echo '</body></html>';
	
	
}
add_action( 'admin_post_nopriv_wptournreg_add_participant', 'wptournreg_add_participant' );
add_action( 'admin_post_wptournreg_add_participant', 'wptournreg_add_participant' );