<?php
/**
 * Template for entry meta
 * @package Asgard
 */
if(!is_single()) {
?>
<div class="entry-meta mb-3">
	<?php
        asgard_posted_on();
        asgard_posted_by();
    ?>
</div>
<?php } ?>