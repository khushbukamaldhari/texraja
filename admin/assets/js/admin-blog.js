$( document ).ready( function () {
    $( document ).on( 'click', '.edit-click', function (e) {
        e.preventDefault();
        
        var pid = $( this ).data( 'pid' );
        var str = 'action=get_data_by_post_id&pid=' + pid;
        $.ajax({
            type: "POST",
            dataType: "html",
            url: ADMIN_AJAX_URL,
            data: str,
            success: function ( data ) {
                var decode = JSON.parse( data );
                get_blogs( decode['data'] );
                
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
    });
     $( document ).on( 'click', '.remove-featured', function (e) {
        $( this ).siblings( '.set-featured ' ).find( 'img' ).remove();
        $( this ).hide();
        
        var pid     = $( '#pid' ).val();
        var str     = 'action=remove_attached_image&pid=' + pid;
        
         $.ajax({
            type: "POST",
            dataType: "html",
            url: ADMIN_AJAX_URL,
            data: str,
            success: function ( data ) {
            var decode = JSON.parse( data );
           
        },
            error: function ( jqXHR, textStatus, errorThrown) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
         
     });
    $( document ).on( 'click', '.delete-click', function (e) {
        e.preventDefault();
        var pid = $( this ).data( 'post_id' );
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this blog!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function ( isConfirm ) {
            if ( isConfirm ) {
                var str = 'action=delete_data_by_post_id&pid=' + pid;
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: ADMIN_AJAX_URL,
                    data: str,
                    success: function ( data ) {
                        var decode = JSON.parse( data );
                        swal( "Deleted!", "Your blog has been deleted.", "success" );
                        $( ".blog_" + pid ).remove();
                    },
                    error: function ( jqXHR, textStatus, errorThrown) {
                        console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                    }
                });
            } else {
                swal( "Cancelled", "", "error" );
            }
        });
    });

    $( document ).on( 'click', '.add-new-blog', function (e) {
        e.preventDefault();
        reset_form( 'frm-add-blog' );
        $( ".editor-wrapper" ).text('');
        $( '.icheckbox_flat-green' ).removeClass( 'checked' );
        $( '.set-featured' ).find( 'img' ).remove();
        $( '.display-add-blog' ).slideToggle();
    });
    
    $( document ).on( 'submit', '#frm-add-blog', function (e) {
        e.preventDefault();
        $( '#descr' ).val( $( '#editor-one' ).html());
        var formData = new FormData( $( this )[0] );
        $.ajax({
            type: "POST",
            dataType: "html",
            cache: false,
            contentType: false,
            processData: false,
            url: ADMIN_AJAX_URL,
            data: formData,
            success: function ( data ) {
            var decode = JSON.parse( data );
            var blog_data = decode['data'];
            reset_form( 'frm-add-blog' );
          
            var html = '<tr class="blog_' + blog_data.post_id + '">' +
                            '<td>' + blog_data.txt_title    + '</td>' +
                            '<td>' + blog_data.category       + '</td>' +
                            '<td>' + blog_data.txt_description        + '</td>' +
                            '<td><button class="btn-success edit-click" data-pid=' + blog_data.post_id + '><i class="fa fa-pencil"></i></button></td>' +
                            '<td><button class="btn-danger delete-click" data-post_id=' + blog_data.post_id + '><i class="fa fa-trash"></i></button></td>' +
                            '</tr>';
                if( $( "#pid" ).val() != 0 ){
                     $( '.display-add-blog' ).slideUp();
                    $( ".blog_"+blog_data.post_id ).replaceWith( html );
                    
                }else{
                     $( '.display-add-blog' ).slideUp();
                    $( ".blog_list tbody" ).prepend( html );
                }                     
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });

    });
  $( document ).on(  "change", "#featured-image",  function (e) {
   
    if ( this.files && this.files[0] ) {
      var reader = new FileReader();
      reader.onload = imageIsLoaded;
      reader.readAsDataURL(this.files[0]);
    }
  });

 });


  function imageIsLoaded(e) {
    var x = 'foo';
    var picture = '<img src="' + e.target.result + '" style="width:200px;height:200px;" class="' + x + 'thImage">'
    $( ".set-featured" ).empty().append( picture );
  }
  
 function get_blogs( data ) {
    $( '#txt-title' ).val( data['title'] );
    $( '#editor-one' ).text( data['contents'] );
    if( data['featured_image'] != '' ) {
        $( '.set-featured' ).html( '<img src="' + data['featured_image'] + '" style="width:200px;height:200px;"/>' );
        $( '.remove-featured' ).show();
    }
    $( '#pid' ).val( data['post_id'] );
    for( var i = 0; i < data['categories'].length; i++ ) {
        $( '.chk-categories' ).each( function () {
            if( data['categories'][i] == $( this ).val() ) {
                $( this ).prop( 'checked', true );
                $( this ).parents( '.icheckbox_flat-green' ).addClass( 'checked' );
            }
        });
    }
    
    $( '.display-add-blog' ).slideDown();
 }