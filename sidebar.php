<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bplate
 */

?>

<aside id="secondary" class="widget-area">
	<?php //Always return the sidebar area in the case custom HTML is needed. ?>
	<?php (is_active_sidebar( 'sidebar-1' )) ? dynamic_sidebar( 'sidebar-1' ) : ""; ?>
</aside><!-- #secondary -->
