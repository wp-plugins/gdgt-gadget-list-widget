<?php
/*
Plugin Name: gdgt gadget list widget
Plugin URI: http://gdgt.com/widgets/
Description: Show off your gadgets! This widget displays your <a href="http://gdgt.com/">gdgt</a> Have, Want, and Had lists.
Version: 1.0.4
Author: Mark Rebec
Author URI: http://user.gdgt.com/markrebec/
*/

define('GDGT_HOST', 'gdgt.com');
define('GDGT_CDN_URL', 'http://media.gdgt.com/');
define('GDGT_URL', 'http://' . GDGT_HOST);
define('GDGT_API_URL', 'http://api.' . GDGT_HOST);
define('GDGT_USR_URL', 'http://user.' . GDGT_HOST);
define('GDGT_IMG_URL', GDGT_CDN_URL . 'img/');
define('GDGT_CSS_URL', GDGT_CDN_URL . 'css/');
define('GDGT_REFRESH_LIST', (60 * 60 * 24));

add_action('init', 'gdgt_gadget_list_init');
function gdgt_gadget_list_init() {
  wp_enqueue_script('gdgt-gadget-list-js', WP_PLUGIN_URL . '/gdgt-gadget-list-widget/gdgt-gadget-list.js');
  wp_enqueue_style('gdgt-gadget-list-css', WP_PLUGIN_URL . '/gdgt-gadget-list-widget/gdgt-gadget-list.css');
}

add_action('widgets_init', create_function('', 'return register_widget("GadgetListWidget");'));
class GadgetListWidget extends WP_Widget {
  function GadgetListWidget() {
    parent::WP_Widget(false, 'gdgt Gadget List', array('description' => 'Show off your gadgets!'));
  }

  function widget($args, $instance) {
    extract($args);
    echo $before_widget;
    $options = array();
    $options['width'] = $instance['width'] ? $instance['width'] : 180;
    $options['height'] = $instance['height'] ? $instance['height'] : 250;
      $options['showcount'] = $instance['showcount'];
      
    gdgt_gadget_list_widget($instance['gdgtuser'], $options);
    echo $after_widget;
  }

  function form($instance) {
    ?>
    <div>
      <p><label for="<?php echo $this->get_field_id('gdgtuser'); ?>">gdgt username:</label></p>
      <p><input type="text" class="widefat" id="<?php echo $this->get_field_id('gdgtuser'); ?>" name="<?php echo $this->get_field_name('gdgtuser'); ?>" value="<?php echo $instance['gdgtuser']; ?>" /></p>
    </div>
    <div>
      <p>
        <label for="<?php echo $this->get_field_id('width'); ?>">width:</label>
        <input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width'] ? $instance['width'] : 200; ?>" style="width: 40px;" />px
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('height'); ?>">height:</label>
        <input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height'] ? $instance['height'] : 300; ?>" style="width: 40px;" />px
      </p>
    </div>
    <div>
      <p>
        show list counts: <input type="radio" id="<?php echo $this->get_field_id('showcount') . '_true'; ?>" name="<?php echo $this->get_field_name('showcount'); ?>" value="true" <?php if ($instance['showcount'] == 'true' || empty($instance['showcount'])) echo 'checked="checked"'; ?> /> <label for="<?php echo $this->get_field_id('showcount') . '_true'; ?>">yes</label> <input type="radio" id="<?php echo $this->get_field_id('showcount') . '_false'; ?>" name="<?php echo $this->get_field_name('showcount'); ?>" value="false" <?php if ($instance['showcount'] == 'false') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->get_field_id('showcount') . '_false'; ?>">no</label>
        <br />
        (only if width is 200px or more)
      </p>
    </div>
    <?php
  }

  function update($new_instance, $old_instance) {
    return $new_instance;
  }
}

function gdgt_gadget_list_widget($username, $options=array()) {
  $now = time();
  $datakey = 'gdgt_widget_' . $username;
  $timekey = $datakey . '_updated';
  $data = (array) unserialize(get_option($datakey));
  $last_updated = get_option($timekey);
  
  if (!$data || !$last_updated || ($now - $last_updated) > GDGT_REFRESH_LIST) {
    $url = GDGT_API_URL . '/profile/' . $username . '/gadgets.pson';
    $stream = fopen($url, 'rb');
    $raw = stream_get_contents($stream);
    if (!($data = unserialize($raw))) {
      $data = array();
    }
    update_option($datakey, serialize($data));
    update_option($timekey, $now);
  }
  create_gadget_list_widget($username, $options, $data);
}

function create_gadget_list_widget($username, $options=array(), $data=null) {
  $have_count = $want_count = $had_count = 0;
  $user_url = $user_img = '';
  if (isset($options['showcount']) && $options['showcount'] === false) {
    $options['showcount'] = 'false';
    $show_counts = false;
  } else {
    $show_counts = true;
  }
  
  if ($data && is_array($data)) {
    $firstname = $data['user']->first_name;
    $user_url = GDGT_USR_URL . '/' . $data['user']->user_name . '/';
    $user_img = GDGT_IMG_URL . $data['user']->avatar_file_path;
    
    if (is_array($data['have']))
      $have_count = count($data['have']);
    if (is_array($data['want']))
      $want_count = count($data['want']);
    if (is_array($data['had']))
      $had_count = count($data['had']);
  
  } else {
    $data = array();
  }
  
  include str_replace(basename(__FILE__), 'widget-skeleton.php', __FILE__);
}
?>