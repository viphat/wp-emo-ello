<?php
/*
Plugin Name: WP Emo Ello
Plugin URI: https://github.com/viphat/wp-emo-ello
Description: Use the Fontello Emoticon set within WordPress. Icons can be inserted using either HTML or a shortcode.
Version: 0.3
Author: viphat
Author URI: https://github.com/viphat/wp-emo-ello
Author Email: viphat@gmail.com
Credits:

- Based on Font Awesome Plugins v4.2 - https://wordpress.org/plugins/font-awesome/ for Tiny MCE Plugins
- Based on Font Emoticons Plugins v1.2 - https://wordpress.org/plugins/font-emoticons/ for Replace WP-Smilies with Fontello Emoticons
- Based on Better Font Awesome Plugins v1.0.6 - https://wordpress.org/plugins/better-font-awesome for Display Icon in TinyMCE Listbox
- Icon set - Fontello.com

License:

  Copyright (C) 2015  Eddie Yang

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

class EmoTelloInfo {
  private $name;
  private $text_reps;
  private $regex;

  public function __construct($name, $text_reps) {
    $this->name = $name;
    $this->text_reps = $text_reps;

    $this->regex = '';
    $is_first = true;
    foreach ($text_reps as $smiley) {
      if ($is_first) {
        $is_first = false;
      }
      else {
        $this->regex .= '|';
      }
      $this->regex .= preg_quote($smiley, '/');
    }

    $this->regex = '/(\s+)(?:'.$this->regex.')(\s+)/U';
  }

  public function insert_emots($post_text) {
    $code = '\\1<i class="icon-emo-'.$this->name.'"></i>\\2';
    return preg_replace($this->regex, $code, $post_text);
  }
}

class EmoTello {
    private static $instance;
    const VERSION = '0.0.1';

    private static function has_instance() {
      return isset( self::$instance ) && null != self::$instance;
    }

    public static function get_instance() {
      if ( ! self::has_instance() ) {
        self::$instance = new EmoTello;
      }
      return self::$instance;
    }

    public static function setup() {
      self::get_instance();
    }

    protected function __construct() {
      if ( ! self::has_instance() ) {
        $this->init();
      }

      $this->SECTION_MASKING_START_DELIM = '@@'.md5('%%%');
      $this->SECTION_MASKING_END_DELIM = md5('%%%').'@@';

      # See: http://codex.wordpress.org/Using_Smilies#What_Text_Do_I_Type_to_Make_Smileys.3F
      $this->emots = array(
        new EmoTelloInfo('happy', array(':)', ':-)', ':smile:')),
        new EmoTelloInfo('unhappy', array(':(', ':-(', ':sad:')),
        new EmoTelloInfo('wink2', array(';)', ';-)', ':wink:')),
        new EmoTelloInfo('tongue', array(':P', ':-P', ':razz:')),
        new EmoTelloInfo('sleep', array('-.-', '-_-', ':sleep:')),
        new EmoTelloInfo('thumbsup', array(':thumbs:', ':thumbsup:')),
        new EmoTelloInfo('devil', array(':devil:', ':twisted:')),
        new EmoTelloInfo('surprised', array(':o', ':-o', ':eek:', '8O', '8o', '8-O', '8-o', ':shock:')),
        new EmoTelloInfo('coffee', array(':coffee:')),
        new EmoTelloInfo('sunglasses', array('8)', '8-)', 'B)', 'B-)', ':cool:')),
        new EmoTelloInfo('displeased', array(':/', ':-/')),
        new EmoTelloInfo('beer', array(':beer:')),
        new EmoTelloInfo('grin', array(':D', ':-D', ':grin:')),
        # No real icon for "mad" available yet. Use the same as angry.
        new EmoTelloInfo('angry', array('x(', 'x-(', 'X(', 'X-(', ':angry:', ':x', ':-x', ':mad:')),
        new EmoTelloInfo('saint', array('O:)', '0:)', 'o:)', 'O:-)', '0:-)', 'o:-)', ':saint:')),
        new EmoTelloInfo('cry', array(":'(", ":'-(", ':cry:')),
        new EmoTelloInfo('shoot', array(':shoot:')),
        new EmoTelloInfo('laugh', array('^^', '^_^', ':lol:'))
      );

      # Disable Wordpress' own smileys
      update_option('use_smilies', 0);

      add_filter('the_content', array($this, 'replace_emots'), 500);
      add_filter('the_excerpt', array($this, 'replace_emots'), 500);
      add_filter('get_comment_text', array($this, 'replace_emots'), 500);
      add_filter('get_comment_excerpt', array($this, 'replace_emots'), 500);

    }

    public function init() {
      add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
      add_action( 'admin_init', array( $this, 'add_tinymce_hooks' ) );
      add_shortcode( 'icon', array( $this, 'setup_shortcode' ) );
      add_filter( 'widget_text', 'do_shortcode' );
    }

    public function add_tinymce_hooks() {
      if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) &&
      get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', array( $this, 'register_tinymce_plugin' ) );
        add_filter( 'mce_buttons', array( $this, 'add_tinymce_buttons' ) );
        add_filter( 'teeny_mce_buttons', array( $this, 'add_tinymce_buttons' ) );
        add_filter( 'mce_css', array( $this, 'add_tinymce_editor_sytle' ) );
      }
    }

    public function register_plugin_styles() {
        global $wp_styles;
        wp_enqueue_style('fontello-styles', plugins_url('assets/css/fontello.css', __FILE__), array(), self::VERSION, 'all');
        wp_enqueue_style('fontello-ie7', plugins_url('assets/css/fontello-ie7.css', __FILE__), array(), self::VERSION, 'all');
        $wp_styles->add_data('fontello-ie7', 'conditional', 'lte IE 7');
    }

    public function setup_shortcode( $params ) {
      return '<i class="icon-' . esc_attr( $params['name'] ) . '">&nbsp;</i>';
    }


    public function register_tinymce_plugin($plugin_array) {
        $plugin_array['emo_ello'] = plugins_url('assets/js/wp-emo-ello.js', __FILE__);
        return $plugin_array;
    }

    public function add_tinymce_buttons($buttons) {
        array_push($buttons,'|','emo_ello');
        return $buttons;
    }

    # ---------------------------------------


    public function add_tinymce_editor_sytle($mce_css) {
        $mce_css .= ', ' . plugins_url('assets/css/admin/editor_styles.css', __FILE__);
        return $mce_css;
    }

    public function replace_emots($content) {
      # surround content with white space so that regexps match emoticons at the beginning and the end
      # of the content correctly.
      $content = ' '.$content.' ';

      #echo "<!--$content-->";

      $content = $this->mask_content($content);

      #echo "<!--$content-->";

      foreach ($this->emots as $emot) {
        $content = $emot->insert_emots($content);
      }

      $content = $this->unmask_content($content);

      # Remove spaces added at the beginning.
      $content = substr($content, 1, -1);

      return $content;
    }

    private function mask_content($content) {
      # Reset placeholders array
      $this->placeholders = array();
      # Mask all code blocks and HTML tags
      return preg_replace_callback('=<pre(?: .+)?>.*</pre>|<code(?: .+)?>.*</code>|<.+>=isU', array($this, 'mask_content_replace_callback'), $content);
    }

    public function mask_content_replace_callback($matches) {
      $matched_text = $matches[0];
      $id = count($this->placeholders);
      $this->placeholders[] = $matched_text;
      $ret = $this->SECTION_MASKING_START_DELIM.$id.$this->SECTION_MASKING_END_DELIM;

      # At this stage, line break characters have already been replaced with <p> and <br> elements. Surround them with
      # spaces to enable emoticon detection. Also, surround HTML comments with spaces.
      #
      # NOTE: At the moment I can't imagine a reason where adding white space around those element would cause any
      #  trouble. I might be wrong though.
      #
      # NOTE 2: The first regexp must match <p>, </p> as well as <br />.
      if (preg_match('#^<[/]?(?:p|br)\s*(?:/\s*)?>$#iU', $matched_text) || preg_match('/<!--.*-->/sU', $matched_text)) {
        $ret = ' '.$ret.' ';
      }
      return $ret;
    }

    private function unmask_content($content) {
      $content = preg_replace_callback('='.$this->SECTION_MASKING_START_DELIM.'(\d+)'.$this->SECTION_MASKING_END_DELIM.'=U', array($this, 'unmask_content_replace_callback'), $content);
      $this->placeholders = array();
      return $content;
    }

    public function unmask_content_replace_callback($matches) {
      $id =  intval($matches[1]);
      return $this->placeholders[$id];
    }

}

EmoTello::setup();

register_deactivation_hook(__FILE__, 'fe_plugin_deactivated');
function fe_plugin_deactivated() {
  # Re-enable Wordpress smileys
  update_option('use_smilies', 1);
}
