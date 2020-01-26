<?php

/* returns a customizable txt file */
function wptournreg_export( $atts = [], $content = null ) {
	
	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
	
	$a = shortcode_atts( array(
		'class' => null,
		'css' => null,
		'css_id' => null,
		'format' => null,
		'linebreak' => '',
		'fields_set' => null,
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
	
	/* add custom CSS */
	$css = ( empty ( $a{ 'css' } ) ) ? '' : ' style="' . $a{ 'css' } . '"';
	$class = ' class="wptournreg-txt' . ( empty ( $a{ 'class' } ) ? '' :  ' ' . $a{ 'class' } ) . '"';
	$id = ( empty ( $a{ 'css_id' } ) ) ? '' : ' id="' . $a{ 'css_id' } . '"';
	
	/* txt structure */
	$format = "<input type='hidden' name='format' value='" . $a[ 'format' ] . "'>";
	$linebreak = '<input type="hidden" name="linebreak" value="' . $a[ 'linebreak' ] . '">';
	$fields_set = "<input type='hidden' name='fields_set' value='" . $a[ 'fields_set' ] . "'>";
	
	/* set action URL */
	$action = ' method="POST" action="' . WP_TOURNREG_ACTION_URL . '"';
	
	return "<form$id$class$css$action target='_blank'><p><strong>$content</strong></p>$tournament$format$linebreak$fields_set" . '<input type="hidden" name="action" value="wptournreg_get_txt"><input type="submit"></form>';
	
}

add_shortcode( 'wptournregexport', 'wptournreg_export' );

/* Action hook of txt form */
function wptournreg_get_txt() {
	
	require_once WP_TOURNREG_DATABASE_PATH . 'select.php';
	$result = wptournreg_select_tournament( $_POST[ 'tournament_id' ] ); 
	
	$formatted = [];
	
	$linebreak = ( !array_key_exists( 'linebreak', $_POST ) || empty ( $_POST[ 'linebreak' ] ) ) ? '' : "\n";
	
	$fields_set = preg_split( '/\s*,\s*/', $_POST[ 'fields_set' ] );
	
	foreach( $result as $participant ) {
		
		$found = true;
		
		if ( !empty( $_POST[ 'fields_set' ] ) ) {
			
			foreach( $fields_set as $available ) {
				
				if ( !array_key_exists( $available, $participant ) || empty ( $participant->{ $available } ) ) {
					
					$found = false;
					break;  
				}
			}
		}
		
		if ( $found ) {error_log('TEST');
		
			$row = $_POST[ 'format' ];
			
			foreach( $participant as $field => $value ) {
				
				$row = str_replace( "%$field%", $value, $row );
				$row = str_replace( '\"', '"', $row );
				$row = str_replace( "\'", "'", $row );
			}
			
			$formatted[] = $row;
		}			
	}
	
	header('Content-Type: text/plain');
	header('Content-Disposition: attachment; filename="wptournreg.txt"');
	
	echo implode( $linebreak, $formatted );
}
add_action( 'admin_post_nopriv_wptournreg_get_txt', 'wptournreg_get_txt' );