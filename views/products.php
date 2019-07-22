<?php
require_once '../config/config.php';
if( !isset($_SESSION['user_id'] ) ) {
    header( 'Location:' . VW_LOGIN );
    exit;
} else if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == "admin" ) {
    header( 'Location:' . VW_ADMIN_HOME );
    exit;
} else {
    
}
include_once FL_PRODUCT;
$product = new product();
$extra_css[] = 'jquery.multiselect.css';
$extra_js[] = 'jquery.multiselect.js';
$extra_css[] = 'jquery.multiselect.filter.css';
$extra_css[] = 'jquery.contextMenu.min.css';
$extra_css[] = 'bootstrap.min.css';
$extra_css[] = 'tokenize2.min.css';
$extra_js[] = 'jquery.multiselect.filter.js';
$extra_js[] = 'user_custom.js';
$extra_js[] = 'tokenize2.min.js';
$extra_js[] = 'user_product.js';
$extra_js[] = 'fixed-table.js';
$extra_js[] = 'jquery.nicescroll.min.js';
$extra_js[] = 'jquery.contextMenu.min.js';
$extra_js[] = 'jquery-ui.min.js';


$common->include_header( 'yarn' );
$user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : 0;
$product_data = $product->get_user_product( $user_id );
?>
<main id="main-section">
    <div class="tr-main-content" id="tr-main-box">
        <div class="tr-table-wrap tr-table-product-wrap">
            <div class="tr-table-product">
                <div class="tr-product-check">
                    <label class="tr-check">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        All
                    </label>
                </div>
                <div class="tr-product-select">
                    <select>
                        <option>All Product</option>
                        <option>All Product01</option>
                        <option>All Product02</option>
                    </select>
                </div>
                <div class="tr-product-sort">
                    <select>
                        <option>Sort</option>
                        <option>Date</option>
                        <option>Time</option>
                    </select>
                </div>
            </div>
            <div class="tr-table-share">
                <a href="#" class="tr-share-icon">
                    <i class="fa fa-share-alt" aria-hidden="true"></i> Share
                </a> 
                <a href="#" class="tr-toggle-icon tr-click-all">
		              <p class="click-show">Show Advance Option</p>
		              <p class="click-hide">Hide Advance Option</p>
		              <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
		        </a>
            </div>
            <div id="fixed-table-container">
                <table class="tr-table product_list">
                    <thead>
                        <tr>
                            <th><p class="tr-pn">Poduct Name</p></th>
                            <th><p class="tr-pp">Product Category</p></th>
                            <th><p class="tr-tom">Type of Machine</p></th>
                            <th><p class="tr-rpf">Rate Per Foot</p></th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php
                        if( isset( $product_data ) && $product_data != "" ) {
                            foreach( $product_data as $pdk => $pdv ) {
                                ?>
                                <tr class="tr-product tr-product-<?php echo $pdv['in_user_product_id']; ?>" data-field="product"  data-field-id="<?php echo $pdv['in_user_product_id']; ?>">                
                                    <td class="menu_cell">
                                        <label class="tr-check">
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                            <span class="span-img">
                                                <img src="<?php echo IMAGES_URL; ?>/product/silk.png" alt="product" />
                                            </span>
                                            <input class="tr-edit" data-field-type="st_product_name"  type="text" name="tr_au_product_name" disabled="" value="<?php echo $pdv['st_product_name']; ?>"/>
                                        </label>
                                    </td>
                                    
                                    <td>
                                        <?php
                                        $product_category = $product->get_attribute_by_type( 'category' );                                           
                                        $product_user_category = $product->get_category_by_user_product_id( $pdv['in_user_product_id'] );
                                        $product_user_category_ids = array();
                                        if( isset( $product_user_category ) && $product_user_category != "" ) {

                                            foreach( $product_user_category as $pck => $pcv ) {
                                                array_push( $product_user_category_ids, $pcv['in_attr_id'] );
                                            }
                                        }
                                        if( isset( $product_category ) && $product_category > 0 ) {?>
                                            <?php
                                            foreach( $product_category as $pck => $pcv ) {
                                                if ( in_array( $pcv['in_attr_id'], $product_user_category_ids ) ) {
                                                    $cat[$pcv['in_attr_id']] = $pcv['st_attr_name'];
                                                    ?>
                                                    <?php
                                                }
                                            }
                                            
                                            ?>
                                        
                                            <select class="category_tags" multiple data-productid="<?php echo $pdv['in_user_product_id']; ?>">
                                                <?php 
                                                    foreach( $product_category as $pck => $pcv ) {
                                                        $selected = ( in_array( $pcv['in_attr_id'], $product_user_category_ids ) ? 'selected' : "" );  
                                                ?>
                                                <option value="<?php echo $pcv['in_attr_id']; ?>" <?php echo $selected; ?>><?php echo $pcv['st_attr_name'];; ?></option>
                                                <?php } ?>
                                                
                                            </select>
                                        <?php } ?>
                                       
                                    </td>
                                    <td>
                                        <?php
                                            $product_user_machinary = $product->get_machinary_by_user_product_id($pdv['in_user_product_id']);
                                            $product_machinary = $product->get_attribute_by_type('machinary');
                                            $product_user_machinary_ids = array();
                                            if( isset( $product_user_machinary ) && $product_user_machinary != "" ) {

                                                foreach( $product_user_machinary as $pck => $pcv ) {
                                                    array_push( $product_user_machinary_ids, $pcv['in_attr_id'] );
                                                }
                                            }
                                        ?>
                                        <?php
                                        if( isset( $product_machinary ) && $product_machinary > 0 ) { ?>
                                           
                                            <select class="machinery_tags" multiple data-productid="<?php echo $pdv['in_user_product_id']; ?>">
                                                <?php 
                                                    foreach( $product_machinary as $pck => $pcv ) {
                                                        $selected = ( in_array( $pcv['in_attr_id'], $product_user_machinary_ids ) ? 'selected' : "" );  
                                                ?>
                                                <option value="<?php echo $pcv['in_attr_id']; ?>" <?php echo $selected; ?>><?php echo $pcv['st_attr_name'];; ?></option>
                                                <?php } ?>
                                                
                                            </select>
                                        
                                        <?php } ?>
                                        
                                    </td>
                                    <td class="cc-common">
                                        <p class="tr-product-price">₹ <input class="tr-edit" type="text" data-field-type="fl_rate" data-field-id="1" name="" disabled="" value="<?php echo $pdv['fl_rate']; ?>"></p> 
                                        <a class="tr-share">
                                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        
                        
                    </tbody>
                </table>
            </div>
            <div class="tr-add-product add_user_product">
                <a href="#" class="tr-product-plus">
                    <i class="fa fa-plus fa-6" aria-hidden="true"></i> Add New Product
                </a>
            </div>
        </div>
        <div class="tr-table-advance">
            <div class="tr-table-title text-center">Advanced Option</div>
               <div class="tr-table-advance-wrap">
                <table class="tr-table">
                    <thead>
                        <tr>
                            <th><p class="tr-pp">Width of Fabric</p></th>
                            <th><p class="tr-pp">Ends per inch</p></th>
                            <th><p class="tr-pp">Pick per inch</p></th>
                            <th><p class="tr-pp">Warp Denier</p></th>
                            <th><p class="tr-pn">Weft Denier</p></th>
                            <th><p class="tr-pn">Total Weight</p></th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php
                    if( isset( $product_data ) && $product_data != "" ) {
                        foreach( $product_data as $pdk => $pdv ) {
                            if( isset( $product_data[$pdk]['properties'] ) && $product_data[$pdk]['properties'] != "" ) {
                                $arr_pro = array();
                                foreach( $product_data[$pdk]['properties'] as $ppk => $ppv ) {
                                    $arr_pro[$ppv['st_properties_key']] = array('key' => $ppv['st_properties_key'],
                                        'value' => $ppv['st_properties_value']
                                    );
                                }
                            }
                            ?>
                            <tr class="tr-product-prop tr-product-prop-<?php echo $pdv['in_user_product_id']; ?>" data-field-id="<?php echo $pdv['in_user_product_id']; ?>" data-field="product_meta">                
                                <td><input type="text" class="tr-edit" data-field-type="<?php echo isset($arr_pro['width_of_fabric']['key']) && $arr_pro['width_of_fabric']['key'] != '' ? $arr_pro['width_of_fabric']['key'] : ''; ?>" name="" disabled="" value="<?php echo isset($arr_pro['width_of_fabric']['value']) && $arr_pro['width_of_fabric']['value'] > 0 ? $arr_pro['width_of_fabric']['value'] : 0; ?>"/> ft</td>
                                <td><input type="text" class="tr-edit" data-field-type="<?php echo isset($arr_pro['ends_per_inch']['key']) && $arr_pro['ends_per_inch']['key'] != '' ? $arr_pro['ends_per_inch']['key'] : ''; ?>" name="" disabled="" value="<?php echo isset($arr_pro['ends_per_inch']['value']) && $arr_pro['ends_per_inch']['value'] > 0 ? $arr_pro['ends_per_inch']['value'] : 0; ?>"/> ft</td>
                                <td><input type="text" class="tr-edit" data-field-type="<?php echo isset($arr_pro['pick_per_inch']['key']) && $arr_pro['pick_per_inch']['key'] != '' ? $arr_pro['pick_per_inch']['key'] : ''; ?>" name="" disabled="" value="<?php echo isset($arr_pro['pick_per_inch']['value']) && $arr_pro['pick_per_inch']['value'] > 0 ? $arr_pro['pick_per_inch']['value'] : 0; ?>"/> ft</td>
                                <td><input type="text" class="tr-edit" data-field-type="<?php echo isset($arr_pro['warp_denier']['key']) && $arr_pro['warp_denier']['key'] != '' ? $arr_pro['warp_denier']['key'] : ''; ?>" name="" disabled="" value="<?php echo isset($arr_pro['warp_denier']['value']) && $arr_pro['warp_denier']['value'] > 0 ? $arr_pro['warp_denier']['value'] : 0; ?>"/> ft</td>
                                <td><input type="text" class="tr-edit" data-field-type="<?php echo isset($arr_pro['weft_denier']['key']) && $arr_pro['weft_denier']['key'] != '' ? $arr_pro['weft_denier']['key'] : ''; ?>" name="" disabled="" value="<?php echo isset($arr_pro['weft_denier']['value']) && $arr_pro['weft_denier']['value'] > 0 ? $arr_pro['weft_denier']['value'] : 0; ?>"/> ft</td>
                                <td><input type="text" class="tr-edit" data-field-type="<?php echo isset($arr_pro['total_weight']['key']) && $arr_pro['total_weight']['key'] != '' ? $arr_pro['total_weight']['key'] : ''; ?>" name="" disabled="" value="<?php echo isset($arr_pro['total_weight']['value']) && $arr_pro['total_weight']['value'] > 0 ? $arr_pro['total_weight']['value'] : 0; ?>"/> ft</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
                    <div>
                    </div>
                </table>
            </div>	
        </div>

    </div>
</main>
<?php
include_once FL_USER_FOOTER_INCLUDE;
$common->include_footer( 'yarn' );
?>