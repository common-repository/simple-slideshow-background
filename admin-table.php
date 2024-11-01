<?php
require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

/*
 * WP-List-Tables
 */

class Slideshow_Background_List_Table extends WP_List_Table {
  function __construct(){
    global $status, $page;
    
    //Set parent defaults
    parent::__construct( array(
        'singular'  => 'step',     //singular name of the listed records
        'plural'    => 'steps',    //plural name of the listed records
        'ajax'      => false        //does this table support ajax?
    ) );  
  }
  
  // Returns column conten for all columns without function column_<name>
  function column_default($item, $column_name){
    switch($column_name){
        default:
            return print_r($item,true); //Show the whole array for troubleshooting purposes
    }
  }
  
  // Handles printing cell for instructions number
  function column_number($item){
    $line = $item['id'] + 1;
    $html = $line."<br/>";
    $html .= '<a href="?page='.$_REQUEST['page'].'&action=delete&id='.$item['id'].'">Delete</a><br/>';
    return $html;
  }
  
  // Handles picture 
  function column_picture($item){
    ?>
    <img class="ssb-admin-img" id="img<?php echo $item['id'];?>" src="<?php echo $item['picture']; ?>" /><br/>
    <form id="save_picture<?php echo $item['id'];?>" action='' method="post">
    <input id="id" name="id" value="<?php echo $item['id'];?>" type="hidden" />
    <input id="action" name="action" value="save_picture" type="hidden"/>
    <input id="picture<?php echo $item['id'];?>" type="hidden" name="picture<?php echo $item['id']; ?>" value="<?php echo $item['picture']; ?>"/>
    <input id="picture_button<?php echo $item['id']; ?>" type="button" value="Upload Image" />
    </form>
    <script language="javascript">
    jQuery(document).ready(function() {

      jQuery('#picture_button<?php echo $item['id']; ?>').click(function() {
       formfield = jQuery('#picture<?php echo $item['id']; ?>').attr('name');
       imgfield = jQuery('#img<?php echo $item['id']; ?>').attr('id');
       form = 'save_picture<?php echo $item['id']; ?>';
       tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
       return false;
      });

      window.send_to_editor = function(html) {
       imgurl = jQuery('img',html).attr('src');
       jQuery('#'+formfield).val(imgurl);
       jQuery('#'+imgfield).attr('src', imgurl);
       jQuery('#'+form).submit();
       tb_remove();
      }

    });
    </script>
    <?
  }
  
  function get_columns(){
    $columns = array(
        'number'     => 'Number',
        'picture' => 'Picture',
    );
    return $columns;
  }
  
  function get_sortable_columns() {
    $sortable_columns = array(
        'number'     => array('number',true),     //true means its already sorted
    );
    return $sortable_columns;
  }
  
  function prepare_items($newrow = false) {
    // WordPress globals
    global $wpdb;
    global $ssbg_option_name;
        
    /**
     * Records per page
     */
    $per_page = 20;


    /**
     * Define Column Headers
     */
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();
    $this->_column_headers = array($columns, $hidden, $sortable);
    
    $data = get_option($ssbg_option_name, array());
    for($id = 0; $id < count($data); $id++){
      $data[$id]['id'] = $id;
    }

    /**
     * Pagination. 
     */
    $current_page = $this->get_pagenum();
    $total_items = count($data);
    $this->number_of_steps = count($data);

    /**
     * array_slice to implement pagination
     */
    $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

    if($newrow){
      array_push($data, array("id" => count($data) - 1, 'picture' => ''));
    }

    /**
     * REQUIRED. Now we can add our *sorted* data to the items property, where 
     * it can be used by the rest of the class.
     */
    $this->items = $data;


    /**
     * REQUIRED. We also have to register our pagination options & calculations.
     */
    $this->set_pagination_args( array(
        'total_items' => $total_items,                  //WE have to calculate the total number of items
        'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
        'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
    ) );
  }
}
?>
