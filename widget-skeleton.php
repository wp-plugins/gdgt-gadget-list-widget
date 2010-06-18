<div id="gdgt_widget_<?php echo $username; ?>" class="gdgt-gadget-list-widget">
  <div class="gdgt-widget-header">
    <a href="<?php echo GDGT_URL; ?>" class="gdgt-logo" title="gdgt"></a>
    <h4><a href="<?php echo $user_url; ?>" title="<?php echo $username; ?> on gdgt">my <strong>gadgets</strong></a></h4>
    <ul class="tabs">
      <li class="have selected"><a class="have" title="have (<?php echo $have_count; ?>)">have <span class="count"><?php if ($have_count > 0 && $show_counts) echo '('.$have_count.')'; ?></span></a></li>
      <li class="want"><a class="want" title="want (<?php echo $want_count; ?>)">want <span class="count"><?php if ($want_count > 0 && $show_counts) echo '('.$want_count.')'; ?></span></a></li>
      <li class="had"><a class="had" title="had (<?php echo $had_count; ?>)">had <span class="count"><?php if ($had_count > 0 && $show_counts) echo '('.$had_count.')'; ?></span></a></li>
    </ul>
  </div>
  
  <div class="gdgt-widget-list">
    <ul class="have-list gadget-list">
      <?php
        if (!empty($data) && is_array($data['have'])) {
          foreach ($data['have'] as $g) {
            ?>
            <li class="list-item">
              <a href="<?php echo GDGT_URL . $g->url; ?>" title="<?php echo $g->name; ?>">
                <img src="<?php echo GDGT_IMG_URL . $g->image; ?>" alt="<?php echo $g->name; ?>" />
                <span><?php echo $g->name; ?></span>
              </a>
            </li>
            <?php
          }
        } else {
          ?>
          <li class="message"><?php echo $username; ?> has made their gadget list private.</li>
          <?php
        }
      ?>
    </ul>
    
    <ul class="want-list gadget-list">
      <?php
        if (!empty($data) && is_array($data['want'])) {
          foreach ($data['want'] as $g) {
            ?>
            <li class="list-item">
              <a href="<?php echo GDGT_URL . $g->url; ?>" title="<?php echo $g->name; ?>">
                <img src="<?php echo GDGT_IMG_URL . $g->image; ?>" alt="<?php echo $g->name; ?>" />
                <span><?php echo $g->name; ?></span>
              </a>
            </li>
            <?php
          }
        } else {
          ?>
          <li class="message"><?php echo $username; ?> has made their gadget list private.</li>
          <?php
        }
      ?>
    </ul>
    
    <ul class="had-list gadget-list">
      <?php
        if (!empty($data) && is_array($data['had'])) {
          foreach ($data['had'] as $g) {
            ?>
            <li class="list-item">
              <a href="<?php echo GDGT_URL . $g->url; ?>" title="<?php echo $g->name; ?>">
                <img src="<?php echo GDGT_IMG_URL . $g->image; ?>" alt="<?php echo $g->name; ?>" />
                <span><?php echo $g->name; ?></span>
              </a>
            </li>
            <?php
          }
        } else {
          ?>
          <li class="message"><?php echo $username; ?> has made their gadget list private.</li>
          <?php
        }
      ?>
    </ul>
  </div>
  
  <div class="gdgt-widget-footer">
    <a href="<?php echo GDGT_URL; ?>/widgets/" class="create-list" title="make your own list!">// make your own list!</a>
  </div>
</div>

<script type="text/javascript">
  var params = {};
  params.user = '<?php echo $username; ?>';
  params.element = '#gdgt_widget_<?php echo $username; ?>';
  <?php if ($options['width']) echo "params.width = ".$options['width'].";"; ?>
  <?php if ($options['height']) echo "params.height = ".$options['height'].";"; ?>
  <?php if ($options['showcount']) echo "params.showCount = ".$options['showcount'].";"; ?>
  gdgt.gadgetListWidget(params);
</script>