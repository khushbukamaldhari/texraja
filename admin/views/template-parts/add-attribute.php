<div class="page-content-wrap" style="margin-top:20px;">
    <div class="row">
        <div class="col-md-12">
            <form id="frm_add_attribute"  style="display: none;" method="post" role="form" class="form-horizontal" action="">                            
                <div class="form-group">
                    <label class="col-md-3">Attribute Type<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="radio" value="category" id="category" name="attr_type" checked="" class='' />
                        <label for="category">Category</label>
                        <input type="radio" value="machinary" id="machinary" name="attr_type" class='' />
                        <label for="machinary">Machinery</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Attribute Name<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="txt_attr_name" name="txt_attr_name"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Attribute Description<span class="required-feild">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="txt_attr_desc" name="txt_attr_desc"/>
                        <span class="help-block"></span>
                    </div>
                </div>
                <input type="hidden" name="hdn_attr_id" id="hdn_attr_id"/>
                <div class="btn-group pull-right">
                    <button class="btn btn-primary loader" type="submit">Submit</button>
                </div>                                                                
            </form>
        </div>
    </div>                    

</div>