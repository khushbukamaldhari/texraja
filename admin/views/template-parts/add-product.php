<div class="page-content-wrap" style="margin-top:20px;">
    <div class="row">
        <div class="col-md-12">
            <form id="frm_add_product"  style="display: none;" method="post" role="form" class="form-horizontal" action="">                            
                <div class="form-group">
                    <label class="col-md-3">Product Name<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="txt_product_name" name="txt_product_name"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Product Description<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="txt_product_desc" name="txt_product_desc"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Product Category<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <select class="form-control" id='dp_category' name='dp_category' multiple>
                            <option>Choose option</option>
                            <?php 
                                $product_category = $product->get_attribute_by_type( 'category' );
                                if( isset( $product_category ) && $product_category > 0 ){
                                    foreach( $product_category as $pck => $pcv ){
                            ?>
                                        <option value="<?php echo $pcv['in_attr_id']; ?>"><?php echo $pcv['st_attr_name']; ?></option>
                             <?php
                                    }
                                }
                             ?>
                      </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Product Machinary<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <select class="form-control" name='dp_machinary' id='dp_machinary' multiple>
                            <option>Choose option</option>
                            <?php 
                                $product_machinary = $product->get_attribute_by_type( 'machinary' );
                                if( isset( $product_machinary ) && $product_machinary > 0 ){
                                    foreach( $product_machinary as $pck => $pcv ){
                            ?>
                                        <option value="<?php echo $pcv['in_attr_id']; ?>"><?php echo $pcv['st_attr_name']; ?></option>
                             <?php
                                    }
                                }
                             ?>
                      </select>
                        <span class="help-block"></span>
                    </div>
                </div>
                
                <input type="hidden" name="hdn_product_id" id="hdn_product_id"/>
                <div class="btn-group pull-right">
                    <button class="btn btn-primary loader" type="submit">Submit</button>
                </div>                                                                
            </form>
        </div>
    </div>                    

</div>