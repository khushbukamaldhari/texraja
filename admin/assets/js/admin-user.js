var draw = 1;
(function ($) {
    
     var get_draw = function(){
        return draw;
    };
    var $dt_user_listing =  $( '#tbl_user_list' ).DataTable( {
        ajax: {
            url:  ADMIN_AJAX_URL,
            type: "POST",
            data: { 
                'action' : "list_users_paged",
            }
        },
        createdRow: function ( row, data, dataIndex ) {
            $( row ).attr( 'data-user-id', data.in_user_id );
        },
        columns: [
            { data: "in_user_id" },
            { data: "st_full_name" },
            { data: "st_email_id" },
            { data: "st_phone_no" },
            { data: "dt_created_at" },
            { data: "action" },
        ],
        order: [ 0, 'desc' ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        }
    } );
    
//    var $dt_user_listing = $( "#tbl_user_list" ).DataTable({
//        processing: true,
//        serverSide: true,
//        ajax: {
//            url: ADMIN_AJAX_URL,
//            type: "POST",
//            cache: false,
//            data: function( data ){
//                data.action = 'list_users_paged';
//                data.draw = draw;
//            },
//            beforeSend: function( data ){
//                ++draw;
//                return data;
//            }
//        },
//        columnDefs: [
//            { name: "in_user_id", targets: 0 },
//            { name: "st_full_name", targets: 1 },
//            { name: "st_email_id", targets: 2 },
//            { name: "st_phone_no", targets: 3 },
//            { name: "dt_created_at", targets: 4 },
//          ],
//        columns: [
//            { data: "in_user_id" },
//            { data: "st_full_name" },
//            { data: "st_email_id" },
//            { data: "st_phone_no" },
//            { data: "dt_created_at" },
//        ],
//        order: [[ 0, "desc" ]]
//    } );
    
    $( document ).on( 'click', '.btn-approve', function( e ) {
            e.preventDefault();
            var user_id = jQuery( this ).closest( 'tr' ).data( 'user-id' );
            swal({
                title: "Are you sure?",
                text: "Are you sure to approve a user?",
                type: "info",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, approve!",
                cancelButtonText: "Nope!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function ( isConfirm ) {
                if ( isConfirm ) {
                    var post_data = {
                        action: 'change_user_status',
                        user: user_id,
                        status: 1
                    };
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: ADMIN_AJAX_URL,
                        data: post_data,
                        success: function ( data ) {
                            var decode = JSON.parse( data );
                            if( data.success_flag == true ){
                                swal( "Approved", "The user has been APPROVED.", "info" );
                            }else{
                                swal( "Approved", "The user has been APPROVED.", "info" );
                            }
                        },
                        error: function ( jqXHR, textStatus, errorThrown ) {
                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                        }
                    });
                    
                }
            });
            return false;
        });
        
        $( document ).on( 'click', '.btn-reject', function( e ) {
            e.preventDefault();
            var user_id = jQuery( this ).closest( 'tr' ).data( 'user-id' );
            swal({
                title: "Are you sure?",
                text: "Are you sure to reject a user?",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Reject!",
                cancelButtonText: "Nope!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function ( isConfirm ) {
                if ( isConfirm ) {
                    var post_data = {
                        action: 'change_user_status',
                        user: user_id,
                        status: -1
                    };
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: ADMIN_AJAX_URL,
                        data: post_data,
                        success: function ( data ) {
                            var decode = JSON.parse( data );
                            if( data.success_flag == true ){
                                swal( "Rejected", "The user has been REJECTED.", "error" );
                                $dt_user_listing.row( "#dt_row_" + user_id ).remove().draw();
                            }else{
                                swal( "Rejected", "The user not REJECTED.", "error" );
                            }
                        },
                        error: function ( jqXHR, textStatus, errorThrown ) {
                            console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                        }
                    });
                }
            });
            return false;
        });
    
})(jQuery);

