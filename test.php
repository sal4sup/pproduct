<?php
/**
 * Template Name: Woocomerce
 *
 */
get_header(); ?>

<?php
$cat_ids = get_option('cat_ids');
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
            $fuck=$_POST[$term->name];
            if (is_array($fuck) || is_object($fuck)) {
                foreach ($fuck as $fu) {
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
?>
<div id="primary" class="content-area">
    <form method="post">
        <?php
        foreach ($cat_ids as $cid) {
            $product_cats=  array('taxonomy' => 'product_cat', 'field' => 'term_id', 'terms' => $cid);
            $term = get_term_by( 'id', $cid, 'product_cat' );
            echo "<h3>".$term->name."</h3>";
            $args = array( 'post_type' => 'product' ,'posts_per_page' => -1,    'tax_query'  => array($product_cats));
            $loop = new WP_Query( $args );
            ?>

            <select name="<?php echo $term->name;?>[]" multiple size="4">
                <?php
                while ( $loop->have_posts() ) : $loop->the_post();
                    $price1=get_post_meta( get_the_ID(), '_regular_price', true);
                    if(!empty($price1)) {
                        ?>

                        <option value="<?php the_title(); ?>|<?php echo $price1; ?>"><?php the_title(); ?></option>


                        <?php
                    }
                    ?>

                <?php endwhile; wp_reset_query();

                ?>
            </select>

        <?php }?>
        <input type="submit" name="submit" value="شراء">
    </form>
</div><!-- .content-area -->

<?php get_footer(); ?>
