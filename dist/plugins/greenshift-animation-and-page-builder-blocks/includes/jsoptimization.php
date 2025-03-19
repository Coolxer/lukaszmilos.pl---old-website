<?php


class GSPBLazyOptimization {

	/**
	 *  constructor.
	 *
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'gs_filter_delayjs' ));
	}

	/**
	 * Checks if is allowed to Delay JS.
	 *
	 */
	public function gs_filter_delayjs() {
		if( ! is_admin() && $this->is_allowed_page() ){
			add_filter( 'script_loader_tag',  array($this,'add_id_to_script'), 10, 3 );
			add_action( 'wp_enqueue_scripts',  array( $this, 'add_delay_js_script' ));
		}
	}

	/**
	 * Checks if page is allowed to Delay JS.
	 *
	 * @return boolean
	 */
	public function is_allowed_page() {

		$global_settings = get_option('gspb_global_settings');
		$delay_js_on = !empty($global_settings['jsdelay']['delay_js_on']) ? $global_settings['jsdelay']['delay_js_on'] : '';

		if( !$delay_js_on){
			return false;
		}

		$delay_js_page_on = !empty($global_settings['jsdelay']['delay_js_page_on']) ? $global_settings['jsdelay']['delay_js_page_on'] : '';

		if($delay_js_page_on){

			$allowedpagesArray = array( );

    		$current_url = home_url( $_SERVER['REQUEST_URI'] );
			
			$delay_js_page_list = !empty($global_settings['jsdelay']['delay_js_page_list']) ? $global_settings['jsdelay']['delay_js_page_list'] : '';

			if($delay_js_page_list){
				$allowedpagesArray = explode( " ", trim($delay_js_page_list) );
			}

			switch ($delay_js_page_on) {
				case "all":
					return true;
				  break;
				case "includefor":
					if (in_array($current_url, $allowedpagesArray) || in_array(untrailingslashit($current_url), $allowedpagesArray)){
						return true;
					}
					return false;
				  break;
				case "excludefor":
					if (in_array($current_url, $allowedpagesArray) || in_array(untrailingslashit($current_url), $allowedpagesArray)){
						return false;
					}
					return true;
				  break;
				default:
			  }
		} 

        return false;
    }

    
	/**
	 * filter out GS scripts tag and add custom attributes to all scripts
	 *
	 * @return string 
	 */
	public function add_id_to_script( $tag, $handle, $src ) {
		$is_gsscript = substr( $handle, 0, 2 );
		if( $is_gsscript === "gs" ){
		
			$tag = preg_replace_callback( '/<script\s*(?<attr>[^>]*)?>(?<content>.*)?<\/script>/Uims', [$this, 'replace_scripts'] , $tag );
		
		}

    	return $tag;
    }

	/**
	 *
	 * @param string $matches script attributes array
	 *
	 * @return string
	 */
	public function replace_scripts( $matches ) {
	
        $src             = '';
        $matches['attr'] = trim( $matches['attr'] );
    
        if ( ! empty( $matches['attr'] ) ) {
            if ( preg_match( '/src=(["\'])(.*?)\1/', $matches['attr'], $src_matches ) ) {
                $src = $src_matches[2];
    
                // Remove the src attribute.
                $matches['attr'] = str_replace( $src_matches[0], '', $matches['attr'] );
            }
        }

    
        if ( empty( $src ) ) {
            return $matches[0];
        }
    
        return "<script type='gslazyloadscript' src='{$src}' {$matches['attr']}></script>";
    }

	/**
	 * Adds the inline script to the footer when the option is enabled.
	 *
	 *
	 * @return void
	 */
	public function add_delay_js_script() {
		wp_enqueue_script( 'jslazyload' );
	}
}


new GSPBLazyOptimization;