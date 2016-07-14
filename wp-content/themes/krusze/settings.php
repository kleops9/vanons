<?php
/**
 * Template Name: Zendesk Settings Template
 * This template is used when settings of zendesk are shown
 *
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
			?>
				
			<?php if($result['headers']['status'] == '200 OK'): ?>
				<select name="snappet_category" onchange="createCookie('snappet_category', $(this).val(), 1);">
					<option>Select category</option>
				 	<?php
				    	$json = json_decode($result['body']);
				    	foreach ($json->categories as $objCategory): 
		    		?>
					<option value="<?php echo $objCategory->id; ?>"><?php echo $objCategory->name; ?></option>
				<?php endforeach; ?>
				</select>
			<?php endif; ?>
		
		<?php
		        $intSnappetCat = isset($_COOKIE["snappet_category"]) ? $_COOKIE["snappet_category"] : false;
		        $json = false;
		        if($intSnappetCat !== false){
					$url = "https://snappet.zendesk.com/api/v2/help_center/categories/$intSnappetCat/sections.json";
					$request = new WP_Http;
					$result = $request->request( $url );
				}
		?>
		<?php if($result['headers']['status'] == '200 OK'): ?>

			<?php print_r($json = json_decode($result['body'])) ?>
		<?php endif; ?>
			<?php do_action('krusze_main_bottom'); ?>
				
			</main><!-- #main -->
			
			<?php do_action('krusze_main_after'); ?>
		
			<?php get_sidebar(); ?>

		</div><!-- .row -->
	</section><!-- .container -->
	
	<?php do_action('krusze_container_after'); ?>

<?php get_footer(); ?>
