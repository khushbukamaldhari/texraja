
var draw = 1; // use a global for the submit and return data rendering
(function ($) {
    var attr_mode = 'new';   
    var product_mode = 'new';   
    var edit_attr = '';
    set_events_fun();
    
    
    
    function set_events_fun() {
        set_edit_attr_events();
        set_attr_delete_events();
        set_edit_product_events();
        set_product_delete_events();
    }
    
    var $dt_product = $( "#product_list" ).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ADMIN_AJAX_URL,
            type: "POST",
            cache: false,
            data: function( data ){
                data.action = 'get_all_product';
                data.draw = draw;
            },
            beforeSend: function( data ){
                ++draw;
                return data;
            }
        },createdRow: function ( row, data, dataIndex ) {
            $( row ).addClass( 'product_' + data.in_product_id );
        },
        columnDefs: [
            { name: "in_product_id", targets: 0 },
            { name: "st_product_name", targets: 1 },
            { name: "st_product_desc", targets: 2 },
            { name: "st_category_name", targets: 3 },
            { name: "st_machinary_name", targets: 4 },
            { name: "action", targets: 5 },
          ],
        columns: [
            { data: "in_product_id" },
            { data: "st_product_name" },
            { data: "st_product_desc" },
            { data: "st_category_name" },
            { data: "st_machinary_name" },
            { data: "action" },
        ],
        order: [[ 0, "desc" ]]
    } );
    
    $( document ).on( 'click', '#btn_add_product', function ( e ) {
        e.preventDefault();
        reset_form( "frm_add_product" );
        product_mode = 'new';
        $("#frm_add_product").slideToggle();
        return false;
    });
    
    var frm_product_validator = $( "#frm_add_product" ).validate({
        onsubmit: true,
        rules: {
            txt_product_name: {
                required: true,
            }, 
            txt_product_name: {
                required: true,
            }, 
            dp_machinary: {
                required: true,
            }, 
            dp_category: {
                required: true,
            }, 
        },
        
    });
    
    $( document ).on( 'submit', '#frm_add_product', function ( e ) {
        show_loader();
        e.preventDefault();
        if( product_mode == 'new' ){
            var str = '&action=add_product';
        }else{
            var str = '&action=edit_product';
        }
        show_loader();
        setTimeout( function(){ 
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        ADMIN_AJAX_URL,
            data:       $( "#frm_add_product" ).serialize()  + str,
            async:      false,
            success:    function ( data ) {
                console.log( data );
                var decode_data = JSON.parse(data);
                if ( decode_data['success_flag'] == true ) {
                    hide_loader();
                    show_new_product( decode_data['data'] );
                    $( "#frm_add_product" ).slideUp();
                    set_edit_attr_events();
                    reset_form( "frm_add_product" );
                    swal( "", decode_data['message'], "success" );
                } else {
                    hide_loader();
                    swal( "", decode_data['message'], "warning" );
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
        }, 1000);
        return false;
    });
    
    function set_edit_product_events() {
        $( ".edit_product" ).unbind( 'click' );
        $( document ).on( 'click', '.edit_product', function ( e ) {    
            var product_id = $( this ).data( 'edit_product' );
            get_product( product_id );
            var product = JSON.parse( edit_attr );
            console.log( product );
            var attr_data = {
                'hdn_product_id': product_id,
                'txt_product_name': product.st_product_name,
                'txt_product_desc': product.st_product_desc
            };
            $( "#hdn_product_id" ).val( product_id );
            $( "#txt_product_name" ).val( product.st_product_name );
            $( "#txt_product_desc" ).val( product.st_product_desc );
            product_mode = 'edit';
            $( "#frm_add_product" ).slideDown();
            return false;
        });
    }
    
    function set_product_delete_events() {
        $( ".delete_product" ).unbind( 'click' );
        $( document ).on( 'click', '.delete_product', function ( e ) {
            var product_id = $(this).data( 'delete_product' );
            show_loader();
            e.preventDefault();
            swal({
                title: "",
                text: "Are you sure you want to delete product?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            },function() {
                var str = 'product_id=' + product_id + '&action=delete_product';
                $.ajax({
                    type:       "POST",
                    dataType:   "html",
                    url:        ADMIN_AJAX_URL,
                    data:       str,
                    async:      false,
                    success: function ( data ) {
                        var decode_data = JSON.parse( data );
                        if ( decode_data['success_flag'] == true ) {
                            $( ".product_" + product_id ).remove();
                        } else {
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    }
                });
            });
            hide_loader();
            return false;
        });
    }

    function get_product( product_id ) {
        show_loader();
        var str = 'action=get_product_by_id&product_id=' + product_id;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: ADMIN_AJAX_URL,
            data: str,
            async: false,
            success: function (data) {
                edit_attr = data;
                hide_loader();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                hide_loader();
            }
        });
    }
    
    function show_new_product ( product_id ) {
        show_loader();
        var str = '&action=get_product_by_id&product_id=' + product_id;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: ADMIN_AJAX_URL,
            data: str,
            async: false,
            success: function ( data ) {
                var product = JSON.parse( data );
                if ( product_mode == 'new' ) {
                    $( "#product_list tbody" ).prepend( '<tr class="product_' + product_id + '">' +
                            '<td>' + product.in_product_id + '</td>' +
                            '<td>' + product.st_product_name + '</td>' +
                            '<td>' + product.st_product_desc + '</td>' +
                            '<td>' + product.st_category_name + '</td>' +
                            '<td>' + product.st_machinary_name + '</td>' +
                            '<td>' +
                                '<span class="edit_product" data-edit_product=' + product.in_product_id + '><i class="fa fa-edit btn btn-primary"></i></span>' +
                                '<span class="delete_product" data-delete_product=' + product.in_product_id + '><i class="fa fa-times btn btn-danger"></i></span>' +
                            '</td>' +
                            '</tr>'
                            );
                } else {
                    $( ".product_" + product_id ).replaceWith( '<tr class="product_' + product_id + '">' +
                            '<td>' + product.in_product_id    + '</td>' +
                            '<td>' + product.st_product_name   + '</td>' +
                            '<td>' + product.st_product_desc   + '</td>' +
                            '<td>' + product.st_category_name   + '</td>' +
                            '<td>' + product.st_machinary_name   + '</td>' +
                            '<td>' +
                                '<span class="edit_product" data-edit_product=' + product.in_product_id + '><i class="fa fa-edit btn btn-primary"></i></span>' +
                                '<span class="delete_product" data-delete_product=' + product.in_product_id + '><i class="fa fa-times btn btn-danger"></i></span>' +
                            '</td>' +
                            '</tr>'
                            );

                }
                hide_loader();
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                hide_loader();
            }
        });
    }
    
    var $dt_user_listing = $( "#tbl_product_attribute" ).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ADMIN_AJAX_URL,
            type: "POST",
            cache: false,
            data: function( data ){
                data.action = 'list_attr_paged';
                data.draw = draw;
            },
            beforeSend: function( data ){
                ++draw;
                return data;
            }
        },createdRow: function ( row, data, dataIndex ) {
            $( row ).addClass( 'attr_' + data.in_attr_id );
        },
        columnDefs: [
            { name: "in_attr_id", targets: 0 },
            { name: "st_attr_name", targets: 1 },
            { name: "st_attr_type", targets: 2 },
            { name: "action", targets: 3 },
          ],
        columns: [
            { data: "in_attr_id" },
            { data: "st_attr_name" },
            { data: "st_attr_type" },
            { data: "action" },
        ],
        order: [[ 0, "desc" ]]
    } );
    
    $( document ).on( 'click', '#btn_add_attribute', function ( e ) {
        e.preventDefault();
        reset_form( "frm_add_attribute" );
        attr_mode = 'new';
        $("#frm_add_attribute").slideToggle();
        $("#hdn_location_action").val('add_attribute');
        return false;
    });
    
    var frm_attribute_validator = $( "#frm_add_attribute" ).validate({
        onsubmit: true,
        rules: {
            txt_attr_name: {
                required: true,
            }, 
            txt_attr_desc: {
                required: true,
            }, 
        },
        
    });
    
    $( document ).on( 'submit', '#frm_add_attribute', function ( e ) {
        show_loader();
        e.preventDefault();
        if( attr_mode == 'new' ){
            var str = '&action=add_attribute';
        }else{
            var str = '&action=edit_attribute';
        }
        show_loader();
        setTimeout( function(){ 
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        ADMIN_AJAX_URL,
            data:       $( "#frm_add_attribute" ).serialize()  + str,
            async:      false,
            success:    function ( data ) {
                console.log( data );
                var decode_data = JSON.parse(data);
                if ( decode_data['success_flag'] == true ) {
                    hide_loader();
                    show_new_attr( decode_data['data'] );
                    $( "#frm_add_attribute" ).slideUp();
                    set_edit_attr_events();
                    reset_form( "frm_add_attribute" );
                    swal( "", decode_data['message'], "success" );
                } else {
                    hide_loader();
                    swal( "", decode_data['message'], "warning" );
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
        }, 1000);
        return false;
    });
    
    function set_edit_attr_events() {
        $( ".edit_attr" ).unbind( 'click' );
        $( document ).on( 'click', '.edit_attr', function ( e ) {    
            var attr_id = $( this ).data( 'edit_attr' );
            get_attr( attr_id );
            var attribute = JSON.parse( edit_attr );
            console.log(attribute);
            var attr_data = {
                'hdn_attr_id': attr_id,
                'txt_attr_name': attribute.st_attr_name,
                'txt_attr_desc': attribute.st_attr_description,
                'txt_attr_desc': attribute.st_attr_type,
            };
            $( "#hdn_attr_id" ).val( attr_id );
            $( "#txt_attr_name" ).val( attribute.st_attr_name );
            $( "#txt_attr_desc" ).val( attribute.st_attr_description );
//            $( "#txt_attr_desc" ).val( attribute.st_attr_description );
            attr_mode = 'edit';
            $( "#frm_add_attribute" ).slideDown();
            return false;
        });
    }
    
    function set_attr_delete_events() {
        $( ".delete_attr" ).unbind( 'click' );
        $( document ).on( 'click', '.delete_attr', function ( e ) {
            var attr_id = $(this).data( 'delete_attr' );
            show_loader();
            e.preventDefault();
            swal({
                title: "",
                text: "Are you sure you want to delete Attribute?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Yes",
                closeOnConfirm: true
            },function() {
                var str = 'attr_id=' + attr_id + '&action=delete_attribute';
                $.ajax({
                    type:       "POST",
                    dataType:   "html",
                    url:        ADMIN_AJAX_URL,
                    data:       str,
                    async:      false,
                    success: function ( data ) {
                        var decode_data = JSON.parse( data );
                        if ( decode_data['success_flag'] == true ) {
                            $( ".attr_" + attr_id ).remove();
                        } else {
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                    }
                });
            });
            hide_loader();
            return false;
        });
    }

    function get_attr( attr_id ) {
        show_loader();
        var str = 'action=get_attribute_by_id&attr_id=' + attr_id;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: ADMIN_AJAX_URL,
            data: str,
            async: false,
            success: function (data) {
                edit_attr = data;
                hide_loader();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                hide_loader();
            }
        });
    }
    
    function show_new_attr ( attr_id ) {
        show_loader();
        var str = '&action=get_attribute_by_id&attr_id=' + attr_id;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: ADMIN_AJAX_URL,
            data: str,
            async: false,
            success: function ( data ) {
                var attribute = JSON.parse( data );
                if ( attr_mode == 'new' ) {
                    $( "#tbl_product_attribute tbody" ).prepend( '<tr class="attr_' + attr_id + '">' +
                            '<td>' + attribute.in_attr_id + '</td>' +
                            '<td>' + attribute.st_attr_name + '</td>' +
                            '<td>' + attribute.st_attr_type + '</td>' +
                            '<td>' +
                                '<span class="edit_attr" data-edit_attr=' + attribute.in_attr_id + '><i class="fa fa-edit btn btn-primary"></i></span>' +
                                '<span class="delete_attr" data-delete_attr=' + attribute.in_attr_id + '><i class="fa fa-times btn btn-danger"></i></span>' +
                            '</td>' +
                            '</tr>'
                            );
                } else {
                    $( ".attr_" + attr_id ).replaceWith( '<tr class="attr_' + attr_id + '">' +
                            '<td>' + attribute.in_attr_id    + '</td>' +
                            '<td>' + attribute.st_attr_name       + '</td>' +
                            '<td>' + attribute.st_attr_type       + '</td>' +
                            '<td>' +
                                '<span class="edit_attr" data-edit_attr=' + attribute.in_attr_id + '><i class="fa fa-edit btn btn-primary"></i></span>' +
                                '<span class="delete_attr" data-delete_attr=' + attribute.in_attr_id + '><i class="fa fa-times btn btn-danger"></i></span>' +
                            '</td>' +
                            '</tr>'
                            );

                }
                hide_loader();
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                hide_loader();
            }
        });
    }
    
})(jQuery);

