  <div id="header-search-panel">
    <div class="container">
      <div class="row-fluid">
        <div class="search">
          <div>
            <form action="<?php echo home_url(); ?>/" id="header-search-form" method="get">
              <input type="text"  id="header-search" name="s" value="" placeholder="<?php echo __('Search','brad');?>" autocomplete="off" />
              <!-- Create a fake search button --> 
              <input type="submit"  name="submit" value="submit" />
            </form>
          </div>
          <p><?php echo __('Hit Enter to Search','brad-framework');?></p>
          <a class="close" href="#">X</a>
        </div>
      </div>
    </div>
  </div>