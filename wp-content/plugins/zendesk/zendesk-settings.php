<?php

    // add menu for selecting a category from zendesk
    add_action('admin_menu', 'zendesk_settings_menu');

    /*
     * Custom menu for the zendesk setting
     */
    function zendesk_settings_menu(){
            add_menu_page( 'Zendesk Settings Page', 'Zendesk Settings', 'manage_options', 'zendesk_settings-plugin', 'zendesk_settings_page' );
    }
     
    function zendesk_settings_page(){
      echo "<h1>Kies de Categorie</h1>";
      echo '<form method="post" name="zendesk_category">';
      echo _getAllCategories();
      submit_button();
      echo '</form>';
    }

    // event that saves the category
    add_action( 'admin_init', 'cd_zendesk_cat_save' );

    /**
     * Saves the category id to db
     */
    function cd_zendesk_cat_save()
    {
      // Make sure your data is set before trying to save it
      if(isset($_POST["snappet_category"])){
        $intCatId = $_POST["snappet_category"];

        global $wpdb;
        $table_name = $wpdb->prefix . 'options';

        // always add the new value
        $wpdb->replace( 
          $table_name, 
          array( 
            'option_name' => "zendesk_category", 
            'option_value' => $intCatId, 
            'autoload' => "no", 
          ) 
        );
      }
    }

    /**
     * Gets all categories from zendesk api
     */
    function _getAllCategories(){
      $res = '';
      $url = 'https://snappet.zendesk.com/api/v2/help_center/categories.json';
      $request = new WP_Http;
      $result = $request->request( $url );
      $json = false;
      if($result['headers']['status'] == '200 OK') {
          $json = json_decode($result['body']);
          $res .= '<select name="snappet_category">';
          $res .= '<option value="0">Select category</option>';
          foreach ($json->categories as $objCategory) {
            $res .= "<option value=\"".$objCategory->id."\" ".(get_option("zendesk_category") == $objCategory->id ? "selected" : "" ).">".$objCategory->name."</option>";
          }
          $res .= "</select>";
      } else {
        $res = "Error connecting to snappet zendesk";
      }
      return $res;
    }