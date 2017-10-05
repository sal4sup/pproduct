<?php
/**
 * @package products-picker
 * @version 1.0
 */
/*
Plugin Name: Products Picker
Plugin URI: http://p-sol.org
Description: WooCommerce Add-Ons is used as a Products Picker allow user to create custom Product and send the order to the admins
Author: Saleem Summmour
Version: 1.0
Author URI: http://p-sol.org/
*/
include (plugin_dir_path(__FILE__) .'ppicker.php');

function perfects_add_admin_page(){
    add_menu_page( 'Products Picker Options', 'PPicker Options', 'manage_options', 'ppicker', 'ppicker_settings_page',  plugin_dir_url( __FILE__ ) .  'img/icon.png', 110 );
    add_submenu_page( 'perfects', 'setting', 'General', 'manage_options', 'ppicker', 'ppicker_settings_page');
    add_action('admin_init','ppicker_setting');

}
add_action('admin_menu', 'perfects_add_admin_page');

function ppicker_setting()
{
    register_setting('ppicker-settings-group','cat_ids');
    register_setting('ppicker-settings-group','multis');
    register_setting('ppicker-settings-group','incs');

    add_settings_section('ppicker-options','Perfects Theme Options','ppicker_options','ppicker');

    add_settings_field('Categories IDs','Categories IDs','categories_ids','ppicker','ppicker-options');


}
function ppicker_settings_page(){
   require_once (plugin_dir_path(__FILE__) .'pp-general.php');

}
function categories_ids(){
    $args = array(
        'orderby'    => 'title',
        'hide_empty' => false,
        'order'      => 'ASC',
    );
    $cat_ids=get_option('cat_ids');
    $multis=get_option('multis');
    $incs=get_option('incs');

    echo " <table>
                <thead>
                <tr>
                    <th>Select</th>
                    <th>Cat name</th>
                    <th>Multiple</th>
                    <th>Increaseable</th>
                </tr>
                </thead>
                <tbody>";
    $product_categories = get_terms( 'product_cat', $args );
        foreach ( $product_categories as $product_category ) {
            $cid=$product_category->term_id;
            echo '<tr>';
            echo '<td>'. $product_category->name.'</td>';
            if(!empty($cat_ids)){
                if (in_array($cid, $cat_ids)){
                    echo '<td><input checked type="checkbox" name="cat_ids[]" value="'.$product_category->term_id.'"></td>';
                }
                else{
                    echo '<td><input  type="checkbox" name="cat_ids[]" value="'.$product_category->term_id.'"></td>';
                }
            }
            else{
                echo '<td><input  type="checkbox" name="cat_ids[]" value="'.$product_category->term_id.' "></td>';
            }
           if(!empty($multis)){
                if (in_array($cid, $multis)){
                    echo '<td><input checked type="checkbox" name="multis[]" value="'.$product_category->term_id.'"></td>';
                }
                else{
                    echo '<td><input type="checkbox" name="multis[]" value="'.$product_category->term_id.'"></td>';
                }
            }
            else{
                echo '<td><input type="checkbox" name="multis[]" value="'.$product_category->term_id.'"></td>';
            }
            if(!empty($incs)){
                if (in_array($cid, $incs)){
                    echo '<td><input checked type="checkbox" name="incs[]" value="'.$product_category->term_id.' "></td>';
                }
                else{
                    echo '<td><input type="checkbox" name="incs[]" value="'.$product_category->term_id.'"></td>';
                }
            }
            else{
                echo '<td><input type="checkbox" name="incs[]" value="'.$product_category->term_id.'"></td>';
            }
            echo '</tr>';

        }
    echo "</tbody></table>";


}

function ppicker_options(){}


?>