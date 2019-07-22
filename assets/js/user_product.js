$(function () {
        $.contextMenu({
            selector: '.menu_cell',
            callback: function (key, options) {
                var parenttr = $(options.$trigger)[0].parentElement ;
                var product_id = $(parenttr).attr('data-field-id');
                if( key == 'duplicate' ) {
                    $.ajax({
                        url:USER_AJAX_URL,
                        type:"post",
                        data:{'action':"duplicate_product",'product_id':product_id},
                        success:function(res){
                            console.log(res);
                        }
                    })
                }
                
            },
            items: {
                duplicate: {name: "Duplicate", icon: "copy"},
                "sep1": "---------",
                "delete": {name: "Delete", icon: "delete"},
            }
        });

        $('.context-menu-one').on('click', function (e) {
            console.log('clicked', this);
        })
    });
(function ($) {
    
    
    $('.category_tags').tokenize2();
    $( '.machinery_tags' ).tokenize2();
    $( '.category_tags' ).on( 'tokenize:tokens:add', function( e, value ){
        var product_id = $( e.target ).attr( 'data-productid' );
        $.ajax({
            url:USER_AJAX_URL,
            type:"post",
            data:{ 'action' : 'update_attribute', "cat_id" : value, "product_id" : product_id },
            success:function( res ){
                
            }
        })
    });
    $( '.machinery_tags' ).on( 'tokenize:tokens:add', function( e, value ){
        var product_id = $( e.target ).attr( 'data-productid' );
        $.ajax({
            url:USER_AJAX_URL,
            type:"post",
            data:{ 'action' : 'update_attribute', "cat_id" : value,"product_id" : product_id },
            success:function( res ){
                
            }
        })
    });
    
    $( '.category_tags' ).on( 'tokenize:tokens:remove', function( e, value ){
        var product_id = $( e.target).attr( 'data-productid' );
        $.ajax({
            url:USER_AJAX_URL,
            type:"post",
            data:{'action':'delete_attribute',"cat_id":value,"product_id":product_id},
            success:function(res){
                console.log(res);   
            }
        })
    });
    $( '.machinery_tags' ).on( 'tokenize:tokens:remove', function( e, value ){
        var product_id = $( e.target).attr( 'data-productid' );
        $.ajax({
            url:USER_AJAX_URL,
            type:"post",
            data:{'action':'delete_attribute',"cat_id":value,"product_id":product_id},
            success:function(res){
                console.log(res);   
            }
        })
    });
    $( document ).on( 'click', ".add_user_product", function(){
       
        $( ".product_list tbody" ).append(  '<tr>' +
                                                '<td>' +
                                                    '<label class="tr-check">' +
                                                        '<input type="checkbox">' +
                                                        '<span class="checkmark"></span>' +
                                                        '<span>' +
                                                            '<img src="' + IMAGE_URL + '/product/silk.png" alt="product" />' +
                                                        '</span>' + 
                                                    '</label>' + 
                                                    '<input class="tr-autosuggestion tr-auto-update tr-au-product" autocomplete="off" data-field-type="st_product_name" type="text" name="tr_au_product_name" />' +
                                                '</td>' +
                                                '<td class="tr-au-category"></td>' +
                                                '<td class="tr-au-machinary"></td>' +
                                                '<td class="cc-common cc-one"><i class="fa fa-rupee"></i>' +
                                                    '<input class="tr-edit" type="text" data-field-type="fl_rate" name="" value="" />' +
                                                    '<a class="tr-share">' +
                                                        '<i class="fa fa-share-alt" aria-hidden="true"></i>' +
                                                    '</a>' +
                                                '</td>' +
                                            '</tr>'
                                            );
                                    fixTable(document.getElementById('fixed-table-container'));
                                    
    });
    
    function analysis_multiselect( element ){
        $( element ).multiselect({
            selectedList: 4 // 0-based index
        });
    }
        
    analysis_multiselect( ".tr_category" );
    
    

    $( document ).on( 'click', ".tr-au-product-list", function(){
        var product_id = $( this ).data( 'au-product' );
        var product_name = $( this ).find( '.tr-product-name' ).text();
        var category_name = $( this ).find( '.tr-category-name' ).text();
        var machinary_name = $( this ).find( '.tr-machinary-name' ).text();
        var $this = $( this );
        if( product_id > 0 ){
            safe_ajax({
                data: { action : 'add_user_product', 
                        value : product_id   
                      },
                callback: function( data ){
                    if( data.success_flag == true ){
                        $this.closest( 'tr' ).find( '.tr-au-product' ).val( product_name );
                        $this.closest( 'tr' ).find( '.tr-au-product' ).after( '<input type="text" class="tr-edit" data-field-type="st_product_name" name="tr_au_product_name" disabled="" data-field-id="' +  data.data["id"] + '" value="' + product_name + '" />' );
                        $this.closest( 'tr' ).find( '.tr-au-category' ).text( category_name );
                        $this.closest( 'tr' ).find( '.tr-au-machinary' ).text( machinary_name );
                        $this.closest( 'tr' ).find( '.tr-au-product' ).remove();
                        $this.closest( 'tr' ).addClass( 'tr-product-' +  data.data['id'] );
                        $this.closest( 'tr' ).addClass( 'tr-product' );
                        $this.closest( 'tr' ).attr( 'data-field', 'product' );
                        $this.closest( 'tr' ).attr( 'data-field-id', data.data['id'] );
                        
                        var markup = get_attribute_markup(product_id);
                        $this.closest( 'tr' ).find( '.tr-au-category' ).html( markup );
                        $('.category_tags').tokenize2();
                        
                        $( ".tr-table-prop tbody" ).append( '<tr class="tr-product-prop tr-product-prop-' +  data.data['id'] + '" data-field-id="' +  data.data['id'] + '" data-field="product_meta">' +                
                            '<td><input type="text" class="tr-edit" data-field-type="' +  data.data['width_of_fabric']['key'] + '" name="" disabled="" value="' +  data.data['width_of_fabric']['value'] + '"/> ft</td>' +
                            '<td><input type="text" class="tr-edit" data-field-type="' +  data.data['ends_per_inch']['key'] + '" name="" disabled="" value="' +  data.data['ends_per_inch']['value'] + '"/> ft</td>' +
                            '<td><input type="text" class="tr-edit" data-field-type="' +  data.data['pick_per_inch']['key'] + '" name="" disabled="" value="' +  data.data['pick_per_inch']['value'] + '"/> ft</td>' +
                            '<td><input type="text" class="tr-edit" data-field-type="' +  data.data['warp_denier']['key'] + '" name="" disabled="" value="' +  data.data['warp_denier']['value'] + '"/> ft</td>' +
                            '<td><input type="text" class="tr-edit" data-field-type="' +  data.data['weft_denier']['key'] + '" name="" disabled="" value="' +  data.data['weft_denier']['value'] + '"/> ft</td>' +
                            '<td><input type="text" class="tr-edit" data-field-type="' +  data.data['total_weight']['key'] + '" name="" disabled="" value="' +  data.data['total_weight']['value'] + '"/> ft</td>' +
                        '</tr>' );
                        $( ".tr-product-list-view" ).hide();
                    }else{

                    }
                }
            });
        }
         
    });
    
    jQuery( document ).on( "keyup", ".tr-autosuggestion", function(){
        var $this = $( this );
        jQuery( this ).autosuggestion({ 
            call: function( el, val ){
                safe_ajax({
                    data: { action : 'get_products_by_keyword', 
                            value : val   
                          },
                    callback: function( data ){
                        if( data.success_flag == true ){
                            var html_list;
                            $( ".tr-product-list-view" ).remove();
                            html_list = '<ul class="tr-product-list-view">';
                            for( var i = 0; i < data.data.length; i++ ){
                                html_list += '<li class="tr-au-product-list" data-au-product="' + data.data[i]['in_product_id'] + '">' +
                                                '<span class="tr-product-name">' + data.data[i]['st_product_name'] + '</span>' +
                                                '<span class="tr-category-name">' + data.data[i]['category'] + '</span>'+ 
                                                '<span class="tr-machinary-name">' + data.data[i]['machinary'] + '</span>' +
                                            '</li>';
                            }
                            html_list += '</ul>';
                            $this.after( html_list );
                        } else if( data.success_flag == false && data.data == 1 ){
                            var html_list = '';
                            $( ".tr-product-list-view" ).remove();
                            html_list = '<ul class="tr-product-list-view">';
                            
                            html_list += '<li>No data Found</li>';
                            html_list += '</ul>';
                            $this.after( html_list );
                            setTimeout( function(){
                                $( ".tr-product-list-view" ).remove();
                            }, 3000);
                        }
                    }
                });
            }, 
            wait: 500, 
            minwords: 3 
        });
    });
    
    $( document ).on( 'dblclick', '.tr-product, .tr-product-prop', function () {
        $( this ).find( ".tr-edit" ).prop( 'disabled' , false );
        $( this ).find( "td:first-child" ).addClass( 'tr-active-row' );
        $( this ).find( "td:last-child" ).addClass( 'tr-active-row' );
    });
    
    $( document ).on( 'focusout', '.tr-product, .tr-product-prop', function () {
        $( this ).find( ".tr-edit" ).prop( 'disabled' , true );
        $( this ).find( "td:first-child" ).removeClass( 'tr-active-row' );
        $( this ).find( "td:last-child" ).removeClass( 'tr-active-row' );
    });
    
    $( document ).on( "change", ".tr-edit", function(){        
        var edit_field = $( this ).closest( 'tr' ).data( 'field' );
        var edit_field_id = $( this ).closest( 'tr' ).data( 'field-id' );
        var edit_field_key = $( this ).data( 'field-type' );
        var edit_field_value = $( this ).val();
        if( edit_field_key != "" && edit_field_value != "" ){
            safe_ajax({
                data: { action : 'edit_product_by_key', 
                        field : edit_field,   
                        id : edit_field_id,   
                        key : edit_field_key,   
                        value : edit_field_value   
                      },
                callback: function( data ){
                    if( data.success_flag == true ){
                        
                    } else if( data.success_flag == false && data.data == 1 ){
                        
                    }
                }
            });
        }
    });
    
})( jQuery );

function get_attribute_markup(product_id){
    $.ajax({
            url:USER_AJAX_URL,
            type:"post",
            data:{'action':'get_attribute_markup',"product_id":product_id},
            success:function(res){
                console.log(res);   
            }
        })
    var markup = "<select multiple class='category_tags'><option value='1' selected>silksss</option></select>";
    return markup
    
}