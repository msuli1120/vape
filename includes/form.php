<?php
	$t_id = $tag->term_id;
	global $wpdb;
	$query = $wpdb->prepare("SELECT logo FROM wp_product_cat_logo WHERE term_id = %d", $t_id);
	$logo = $wpdb->get_results($query);
	if ($logo) {
		$path = $logo[0]->logo;
  }
?>
<input type="hidden" name="term_id" value="<?php echo $t_id; ?>">
<div class="form-field">

  <h4><label for="product_cat_logo">Category Logo</label></h4>

  <?php
    if (isset( $path)) {
      ?>
      <img src=<?php echo $path; ?> width="75">
      <?php
    }
  ?>

  <input type="hidden" id="product-cat-logo" name="product_cat_logo" <?php if (isset( $path)) { echo 'value='.$path; } ?>>
  <a href="#" class="product-cat-logo-button button">Choose Image</a>
  <a href="#" class="remove-cat-log-button button">Remove Image</a>


</div>