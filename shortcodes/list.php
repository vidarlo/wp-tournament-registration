<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* stores the form data (no params) */
function wptournreg_get_list( $atts = [] ) {
	
	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
	
	$a = shortcode_atts( array(
		'backlink' => null,
		'class' => null,
		'css' => null,
		'css_id' => null,
		'display_fields' => null,
		'headings' => null,
		'protected_fields' => null,
		'notsortable' => null,
		'tournament_id' => null,
	), $atts );
	
	if ( empty ( $a[ 'tournament_id' ] ) ) {
		
		return sprintf( __( '%sERROR: Missing %s in shortcode %s!%s', 'wp-tournament-registration' ), '<strong class="wptournreg-error">', '<kbd>tournament_id</kbd>', '<kbd>wptournreglist</kbd>', '</strong>' );
	}
	
	if ( empty ( $a[ 'notsortable' ] ) ) {
		
		wp_enqueue_script( 'wptournregtablesorter' );
		wp_enqueue_style( 'wptournregtablesorter' );
	}
	wp_enqueue_script( 'wptournreg' );
	wp_enqueue_style( 'wptournreg' );
	
	require_once WP_TOURNREG_DATABASE_PATH . 'select.php';
	$result = wptournreg_select_tournament( $a[ 'tournament_id' ] ); 
	
	require_once WP_TOURNREG_DATABASE_PATH . 'scheme.php';
	$scheme = wptournreg_get_field_list();
	
	$fields = preg_split( '/\s*,\s*/', $a[ 'display_fields' ]);
	$protected_fields = preg_split( '/\s*,\s*/', $a[ 'protected_fields' ]);
	
	/* add custom CSS */
	$css = ( empty ( $a{ 'css' } ) ) ? '' : ' style="' . $a{ 'css' } . '"';
	$class = ' class="wptournreg-list' . ( empty ( $a{ 'class' } ) ? '' : ' ' . $a{ 'class' } ) . '"';
	$id = ( empty ( $a{ 'css_id' } ) ) ? '' : ' id="' . $a{ 'css_id' } . '"';
	
	
	/* Print table */
	$html = "<figure$id$class$css><table><thead><tr><th>#</th>";
	
	/* we need headings due to sorting */
	if ( !empty ( $a[ 'headings' ] ) ) {
		
		$headings = preg_split( '/\s*,\s*/', $a[ 'headings' ]);
	}
	else {
		
		$headings = $fields;
	}
	
	foreach( $headings as $th ) {
		
		$html .= "<th>$th</th>";
	}
	
	$html .= '</tr></thead><tbody>';
	
	$count = 0;
	
	foreach( $result as $participant ) {
		
		if ( $participant->{ 'approved' } ) {
		
			$html .= '<tr><td>' . ++$count . '</td>';
			
			if ( $participant->{ 'protected' } == 1 ) {
				
				$protected = true;
			}
			else {
				
				$protected = false;
			}
		
			foreach( $fields as $field ) {
				
				if ( array_key_exists( $field, $participant ) ) {
											
					if ( $protected && in_array( $field, $protected_fields ) && !empty( $participant->{ $field } ) ) {
						
							$value = '***';
					}
					else if ( preg_match( '/bool|int\(1\)/i', $scheme[ $field ] ) ) {
						
						$value = ( $participant->{ $field } == 1) ? 'X' : '';;
					}
					else if ( strcmp( $field, 'email' ) === 0 ) {
						
						$value = '<a href="mailto:' . $participant->{ $field } . '">' . $participant->{ $field } . '</a>';
					}
					else if ( strcmp( $field, 'time' ) === 0 ) {
						
						$value = wp_date( get_option( 'date_format' ), $participant->{ 'time' } );
					}
					else {
						
						$value = $participant->{ $field };
					}
				
					$html .= '<td>' . $value . '</td>';
				}
				
			}
			
			$html .= '</tr>';
		}
	}
	
	$html .= '</tbody></table></figure>';
	
	if ( !empty ( $a{ 'backlink' } ) ) {
		require_once WP_TOURNREG_HTML_PATH . 'backlink.php';
		$html .= wptournreg_get_backlink( 'list' );
	}
	
	return $html;
	
	#return print_r($result);
	
}

add_shortcode( 'wptournreglist', 'wptournreg_get_list' );