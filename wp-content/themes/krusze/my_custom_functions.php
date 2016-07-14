<?php

/**
 * Gets all articles that matches the search query
 * @return the results
 */
function _searchZendesk(){
	$res = '';

  	$strSearch = get_search_query();
	if(!empty($strSearch)){
		$url = 'https://snappet.zendesk.com/api/v2/help_center/articles/search.json?query='.$strSearch;
		$request = new WP_Http;
		$result = $request->request( $url );
		if($result['headers']['status'] == '200 OK'){
		    $json = json_decode($result['body']);
	    	foreach ($json->results as $objArticle){
				$res .= "<p>".$objArticle->title."</p>";
			}
		}
	}
	
	return $res;
}

/**
 * Gets all articles from the selected section
 * @param integer $intCatId The category id
 * @param string $strName A unique name for the selectbox
 * @return the selectbox
 */
function _getAllArticlesFromSection($intPostId){
	$res = '';
	$values = get_post_custom( $intPostId );

  	// always single value get the first element of array
  	$intSectionId = isset( $values['zendesk_meta_box_select'] ) ? esc_attr( array_pop($values['zendesk_meta_box_select']) ) : '';
	
	if(!empty($intSectionId)){
		$url = 'https://snappet.zendesk.com/api/v2/help_center/sections/'.$intSectionId.'/articles.json';
		$request = new WP_Http;
		$result = $request->request( $url );
		if($result['headers']['status'] == '200 OK'){
		    $json = json_decode($result['body']);
	    	foreach ($json->articles as $objArticle){
				$res .= "<p>".$objArticle->title."</p>";
			}
		} else {
			$res .= "<p>No results for this section</p>";
		}
	} else {
		$res .= "<p>No section found</p>";
	}
	
	return $res;
}

// Add custom meta box for the zendesk info
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add()
{
    add_meta_box( 'zendesk-meta-box-id', 'Zendesk Meta Box', 'cd_meta_box_cb', 'vragen', 'normal', 'high' );
}

// The zendesk metabox template
function cd_meta_box_cb()
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'zendesk_meta_box_nonce', 'zendesk_meta_box_nonce' );
    ?>
    <p>
    	<?php 
    		$intCatId = get_option("zendesk_category");
		?>
    	<?php if(!empty($intCatId)): ?>
    		<label for="zendesk_meta_box_select">Section</label>
	    	<?php echo _getAllSectionsFromCategory($intCatId, "zendesk_meta_box_select"); ?>
    	<?php else: ?>
    		<p>No Category has been selected in Zendesk settings</p>
    	<?php endif; ?>
    </p>

    <?php    
}

/**
 * Gets all section from the selected category
 * @param integer $intCatId The category id
 * @param string $strName A unique name for the selectbox
 * @return the selectbox
 */
function _getAllSectionsFromCategory($intCatId, $strName){
    // $post is already set, and contains an object: the WordPress post
  global $post;
  $values = get_post_custom( $post->ID );
  
  // always single value get the first element of array
  $strSelected = isset( $values['zendesk_meta_box_select'] ) ? esc_attr( array_pop($values['zendesk_meta_box_select']) ) : '';

  $res = '';
  $url = 'https://snappet.zendesk.com/api/v2/help_center/categories/'.$intCatId.'/sections.json';
  $request = new WP_Http;
  $result = $request->request( $url );
  $json = false;
      
  if($result['headers']['status'] == '200 OK') {
      $json = json_decode($result['body']);
      $res .= '<select name="'.$strName.'" id="'.$strName.'">';
      $res .= '<option>Select section</option>';
      foreach ($json->sections as $objSection) {
        $res .= '<option value="'.$objSection->id.'" '.( $strSelected == $objSection->id ? 'selected' : '').'>'.$objSection->name.'</option>';
      }
      $res .= "</select>";
  } else {
    $res = "<p>Error connecting to snappet zendesk</p>";
  }
  return $res;
}

// Save the custom meta box value
add_action( 'save_post', 'cd_meta_box_save' );

/**
 * Saves the custom metabox value
 * @param integer $post_id The post id
 */
function cd_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['zendesk_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['zendesk_meta_box_nonce'], 'zendesk_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
   
    // Make sure your data is set before trying to save it
    if( isset( $_POST['zendesk_meta_box_select'] ) )
        update_post_meta( $post_id, 'zendesk_meta_box_select', esc_attr( $_POST['zendesk_meta_box_select'] ) );
         
}

