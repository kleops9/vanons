<?php
/**
 * Settings Template
 * This template is used when settings of zendesk are shown
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Krusze
 */

get_header(); ?>

	<?php do_action('krusze_container_before'); ?>
	
	<section class="container">
		<div class="row">

			<?php do_action('krusze_main_before'); ?>
			
			<main id="main" class="site-main" role="main">
			
			<?php do_action('krusze_main_top'); ?>
					
			<?php
				$url = 'https://snappet.zendesk.com/api/v2/help_center/categories.json';
				$request = new WP_Http;
				$result = $request->request( $url );
				$json = false;
				if($result['status'] == '200'){
				    $json = $result['body'];
				}
			?>
			<select name="category">
				<?php foreach ($json['categories'] as $arrCategory): ?>
					<option value="<?php echo $arrCategory['id']; ?>"><?php echo $arrCategory['name']; ?></option>
				<?php endforeach; ?>
			</select>
		
			do_action('krusze_main_bottom'); ?>
				
			</main><!-- #main -->
			
			<?php do_action('krusze_main_after'); ?>
		
			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</section><!-- .container -->
	
	<?php do_action('krusze_container_after'); ?>

<?php get_footer(); ?>
