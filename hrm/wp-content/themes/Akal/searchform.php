<form action="<?php echo home_url(); ?>/" id="searchform" class="search-form" method="get">
  <div>
    <input type="text" id="s" name="s" value="<?php _e('Search...', 'brad') ?>" onfocus="if(this.value=='<?php _e('Search...', 'brad') ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e('Search...', 'brad') ?>';" autocomplete="off" />
    <input type="submit" value="<?php echo __('Go','brad');?>"  />
  </div>
</form>


      