<?php
/**
 * @package products-picker
 * @version 1.0
 */


function ppicker(){
    $cat_ids = get_option('cat_ids');
    $multis=get_option('multis');
    $incs=get_option('incs');

    $total=0;
    if(isset($_POST["submit"])){
        ?>
        <table>
            <thead>
            <tr>
                <th>item name</th>
                <th>item price</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($cat_ids as $cid) {
                $product_cats = array('taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $cid);
                $term = get_term_by('id', $cid, 'product_cat');
                $pc=$_POST[$term->name];
                if (is_array($pc) || is_object($pc)) {
                    foreach ($pc as $fu) {
                        ?>
                        <tr>
                            <?php
                            $selecteditem=explode('|',$fu);
                            $item_name=$selecteditem[0];
                            $item_price=$selecteditem[1];
                            echo "<td>".$item_name."</td>";
                            echo "<td>".$item_price."</td>";
                            $total+=(int)$item_price;
                            ?>
                        </tr>
                        <?php

                    }
                }
            }?>
            </tbody>
            <tfoot>
            <tr>
                <th>Total</th>
                <th><?php echo $total;?></th>
            </tr>
            </tfoot>
        </table>
        <?php
    }

    echo '<form method="post">';

    foreach ($cat_ids as $cid) {
        $product_cats=  array('taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $cid);
        $term = get_term_by( 'id', $cid, 'product_cat' );
        echo "<h3>".$term->name."</h3>";
        $args = array( 'post_type' => 'product' ,'posts_per_page' => -1,'tax_query'  => array($product_cats));
        $loop = new WP_Query( $args );
        if(!empty($multis)){
            if (in_array($cid, $multis)){
                echo '<select name="'.$term->name.'[]" multiple size="4">';
            }
            else {
                echo '<select name="'.$term->name.'[]">';
            }
        }
        else {
            echo '<select name="'.$term->name.'[]">';
        }
        while ( $loop->have_posts() ) : $loop->the_post();
            $price1=get_post_meta( get_the_ID(), '_regular_price', true);

            if(!empty($price1)) {
                ?>
                <option value="<?php the_title(); ?>|<?php echo $price1; ?>"><?php the_title(); ?></option>
                <?php
            }
        endwhile; wp_reset_query();
        echo '</select>';
            if (in_array($cid, $incs)){
                echo '<input type="number"';
            }

        

}

    echo '<Br><br><input type="submit" name="submit" value="شراء">';
    echo "</form>";

}


add_shortcode( 'ppicker', 'ppicker' );
?>
