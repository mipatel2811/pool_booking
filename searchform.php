<form method="get" class="searchform" action="<?php echo esc_url(home_url()); ?>/">
	<input type="text" name="s" id="s" value="<?php _e('Search here..', 'wp-fanzone'); ?>" onfocus='if (this.value == "<?php _e('Search here..', 'wp-fanzone'); ?>") { this.value = ""; }' onblur='if (this.value == "") { this.value = "<?php _e('Search here..', 'wp-fanzone'); ?>"; }' />
	<input type="image" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/search-button.png" alt="Search" id="search-button">
</form>