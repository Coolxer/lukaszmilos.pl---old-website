<?php


namespace greenshift\Blocks;
defined('ABSPATH') OR exit;


class GSToc{

	public function __construct(){
		add_action('init', array( $this, 'init_handler' ));
	}

	public function init_handler(){
		register_block_type(__DIR__, array(
                'render_callback' => array( $this, 'render_block' ),
                'attributes'      => $this->attributes
            )
		);
	}

	public $attributes = array(
		'id' => array(
			'type'    => 'string',
			'default' => null,
		),
		'inlineCssStyles' => array(
			'type'    => 'string',
			'default' => '',
		),
		'animation' => array(
			'type' => 'object',
			'default' => array(),
		),
        'dynamicTOC' => array(
            'type' => 'boolean',
            'default' => false
        ),
        'seoschema' => array(
            'type' => 'boolean',
            'default' => false
        ),
        'headingTag'=> array(
            'type' => 'string',
            'default' => 'h2'
        ),
        'headingSecTag'=> array(
            'type' => 'string',
            'default' => ''
        ),
        'enablenumbers'=> array(
            'type' => 'boolean',
            'default' => true
        ),
        'stickyPanel'=> array(
            'type' => 'boolean',
            'default' => false
        ),
        'stickyPanelOnly'=> array(
            'type' => 'boolean',
            'default' => false
        ),
        'offset' => array(
            'type' => 'number',
            'default' => 50
        ),
	);

	public function render_block($settings = array(), $inner_content=''){
		extract($settings);
        $out = '';
        if($dynamicTOC){
            global $post;
            if(!is_object($post)) return;
            $blockId = 'gspb_toc-id-'.esc_attr($id);
            $blockClassName = 'gs-toc '.$blockId.' '.(!empty($className) ? esc_attr($className) : '').' ';
            $seotype = ($seoschema) ? ' itemType="https://schema.org/ItemList" itemscope=""' : '';
    
            $headings = self::get_headings($post->post_content, $settings);
            if (empty($headings)) {
            } else {
                $out = '<div id="'.$blockId.'"'.$seotype.' data-offset="'.$offset.'" class="'.$blockClassName.'"'.gspb_AnimationRenderProps($animation).'>';
                    $key = 0;
                    $schematype = ' itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"';
                    if(!$stickyPanelOnly){
                        $out .= '<div class="gs-autolist">';
                        foreach ($headings as $key => $heading) {
                            if(empty($heading['name']) || empty($heading['id'])) continue;
                            if(!empty($heading['classes']) && in_array('remove-from-toc', $heading['classes'])) continue;
                            if('h'.$heading['tag'] == $headingTag || 'h'.$heading['tag'] == $headingSecTag){
                                $subheadingclass = ($headingSecTag == 'h'.$heading['tag']) ? " gs_sub_heading": "";
                                $out .= '<div class="gs-autolist-item'.esc_attr($subheadingclass).'"'.($seoschema ? $schematype : "").'>';
                                    if($enablenumbers) {
                                        $out .= '<span class="gs-autolist-number">'.($key+1).'</span>';
                                    }
                                    $out .= '<span class="gs-autolist-title">';
                                        if($seoschema){
                                            $out .= '<meta itemProp="name" content="'.esc_attr($heading['name']).'" />';
                                        }
                                        $out .= '<a class="gs-scrollto" href="#'.esc_attr($heading['id']).'">';
                                            $out .= esc_attr($heading['name']);
                                        $out .='</a>';
                                    $out .='</span>';
                                $out .= '</div>';
                            }
                        }
                        $out .= '</div>';
                    }
                    if($stickyPanel){
                        $out .= '<nav class="gs-section-sticky-nav"><ul class="gs-sticky-toc-list">';
                        foreach ($headings as $key => $heading) {
                            if(empty($heading['name']) || empty($heading['id'])) continue;
                            if(!empty($heading['classes']) && in_array('remove-from-toc', $heading['classes'])) continue;
                            if('h'.$heading['tag'] == $headingTag || 'h'.$heading['tag'] == $headingSecTag){
                                $subheadingclass = ($headingSecTag == 'h'.$heading['tag']) ? " gs_sub_heading": "";
                                $out .= '<li class="'.esc_attr($subheadingclass).'"'.(($seoschema && $stickyPanelOnly) ? $schematype : "").'>';
                                    $out .= '<span class="gs-autolist-title">';
                                        if($seoschema && $stickyPanelOnly){
                                            $out .= '<meta itemProp="name" content="'.esc_attr($heading['name']).'" />';
                                        }
                                        $out .= '<a class="gs-scrollto" href="#'.esc_attr($heading['id']).'">';
                                            $out .= esc_attr($heading['name']);
                                        $out .='</a>';
                                    $out .='</span>';
                                $out .= '</li>';
                            }
                        }
                        $out .= '</ul><div class="gs-toc-mobile"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="29.957px" height="122.88px" viewBox="0 0 29.957 122.88"><g><path d="M14.978,0c8.27,0,14.979,6.708,14.979,14.979c0,8.27-6.709,14.976-14.979,14.976 C6.708,29.954,0,23.249,0,14.979C0,6.708,6.708,0,14.978,0L14.978,0z M14.978,92.926c8.27,0,14.979,6.708,14.979,14.979 s-6.709,14.976-14.979,14.976C6.708,122.88,0,116.175,0,107.904S6.708,92.926,14.978,92.926L14.978,92.926z M14.978,46.463 c8.27,0,14.979,6.708,14.979,14.979s-6.709,14.978-14.979,14.978C6.708,76.419,0,69.712,0,61.441S6.708,46.463,14.978,46.463 L14.978,46.463z"></path></g></svg></div></nav>';                            
                    }
                $out .='</div>';
            }
        }else{
            $out = $inner_content;
        }
		return $out;
	}

    static function get_toc_blocks($blocks, $settings) {
        $headings = [];
        extract($settings);
        foreach ($blocks as $block) {
            if(!empty( $block['attrs']['className'])){
                if(strpos($block['attrs']['className'], 'remove-from-toc') !== false){
                    continue;
                }
            }
            if ($block['blockName'] == 'core/heading') {                          
                if(!empty($block['attrs']['level']) && ('h'.$block['attrs']['level'] == $headingTag || 'h'.$block['attrs']['level'] == $headingSecTag)){
                    if(!empty($block['attrs']['anchor']) || !empty($block['attrs']['customAnchor'])){
                        $headarray = [];
                        $headarray['title'] = wp_strip_all_tags($block['attrs']['content']);
                        $anchor = !empty($block['attrs']['anchor']) ? $block['attrs']['anchor'] : $block['attrs']['customAnchor'];
                        $headarray['anchor'] = wp_strip_all_tags($anchor);
                        if('h'.$block['attrs']['level'] == $headingSecTag){
                            $headarray['subheading'] = true;
                        }
                        $headings[] = $headarray;
                    }
                } 
            }
            else if ($block['blockName'] == 'greenshift-blocks/heading') { 
                if(!empty($block['attrs']['headingTag']) && ($block['attrs']['headingTag'] == $headingTag || $block['attrs']['headingTag'] == $headingSecTag)){
                    if(!empty($block['attrs']['anchor']) || !empty($block['attrs']['customAnchor'])){
                        $headarray = [];
                        $headarray['title'] = wp_strip_all_tags($block['attrs']['headingContent']);
                        $anchor = !empty($block['attrs']['anchor']) ? $block['attrs']['anchor'] : $block['attrs']['customAnchor'];
                        $headarray['anchor'] =  wp_strip_all_tags($anchor);
                        if($block['attrs']['headingTag'] == $headingSecTag){
                            $headarray['subheading'] = true;
                        }
                        $headings[] = $headarray;
                    }
                }                              
            }else if ($block['blockName'] == 'greenshift-blocks/element') {  
                if(!empty($block['attrs']['tag']) && ($block['attrs']['tag'] == $headingTag || $block['attrs']['tag'] == $headingSecTag)){
                    if(!empty($block['attrs']['anchor']) || !empty($block['attrs']['customAnchor'])){
                        $headarray = [];
                        $headarray['title'] = wp_strip_all_tags($block['attrs']['textContent']);
                        $anchor = !empty($block['attrs']['anchor']) ? $block['attrs']['anchor'] : $block['attrs']['customAnchor'];
                        $headarray['anchor'] =  wp_strip_all_tags($anchor);
                        if($block['attrs']['tag'] == $headingSecTag){
                            $headarray['subheading'] = true;
                        }
                        $headings[] = $headarray;
                    }
                }                              
            }else if(!empty($block['innerBlocks'])){
                $headings = array_merge($headings, self::get_toc_blocks($block['innerBlocks'], $settings));
            }
        }
        return $headings;
    }

    static function get_headings($content, $settings) {
            extract($settings);
            $headings = [];
            $range = str_replace('h', '', $headingTag);
            if($headingSecTag){
                $range = str_replace('h', '', $headingTag) . '-' . str_replace('h', '', $headingSecTag);
            }
            preg_match_all("/<h([" . $range . "])([^<]*)>(.*)<\/h[" . $range . "]>/", $content, $matches);
            
            for($i = 0; $i < count($matches[1]); $i++) {
              $headings[$i]["tag"] = $matches[1][$i];
              // get id
              $att_string = $matches[2][$i];
              preg_match("/id=\"([^\"]*)\"/", $att_string , $id_matches);
              if(!empty($id_matches[1])){
                $headings[$i]["id"] = $id_matches[1];
              }
              // get classes
              $att_string = $matches[2][$i];
              preg_match_all("/class=\"([^\"]*)\"/", $att_string , $class_matches);
              for($j = 0; $j < count($class_matches[1]); $j++) {
                $headings[$i]["classes"] = explode(" ", $class_matches[1][$j]);
              }
              $headings[$i]["name"] = strip_tags($matches[3][$i]);
            }
            return $headings;
    }

}

new GSToc;