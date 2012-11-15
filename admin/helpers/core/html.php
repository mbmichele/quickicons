<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_akquickicons
 *
 * @copyright   Copyright (C) 2012 Asikart. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Generated by AKHelper - http://asikart.com
 */


// No direct access
defined('_JEXEC') or die;


class AkquickiconsHelperHtml {
	
	public static function repair($html , $use_tidy = true ) {
		
		if(function_exists('tidy_repair_string') && $use_tidy ):
		
			$TidyConfig = array('indent' 			=> true,
	                			'output-xhtml' 		=> true,
	                			'show-body-only' 	=> true,
	                			'wrap'				=> false
	                			);
	        return tidy_repair_string($html,$TidyConfig,'utf8');
		
        else:
		
        	$arr_single_tags = array('meta','img','br','link','area');
		    
			//put all opened tags into an array
		    preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
		    $openedtags = $result[1];
		 
		    //put all closed tags into an array
		    preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
		    $closedtags = $result[1];
		    $len_opened = count ( $openedtags );
			
		    // all tags are closed
		    if( count ( $closedtags ) == $len_opened )
		    {
		        return $html;
		    }
			
		    $openedtags = array_reverse ( $openedtags );
		    
			// close tags
		    for( $i = 0; $i < $len_opened; $i++ )      
		    {
		        if ( !in_array ( $openedtags[$i], $closedtags ) )
		        {
		            if(!in_array ( $openedtags[$i], $arr_single_tags )) $html .= "</" . $openedtags[$i] . ">";
		        }
		        else
		        {
		            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
		        }
		    }
			
		    return $html;
		
        endif;
	}
}

