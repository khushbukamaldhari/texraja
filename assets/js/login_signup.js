(function ($) {
    
    var reg_validator = $( "#frm_signup" ).validate({
        onsubmit: true,
        rules: {
            txt_adhar_no: {
                required: true,
                minlength: 16,
                maxlength: 16,
                number: true
            },
            txt_gst_no: {
                required: true
            },
            txt_email: {
                required: true,
                email: true
            },
            txt_password: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            txt_cpassword: {
                required: true,
                minlength: 6,
                maxlength: 16,
                equalTo: "#txt_password"
            },
        },
    });
    
    $( document ).on( "keyup", "#txt_gst_no", function(){    
        var inputvalues = $(this).val();
        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
        if( gstinformat.test( inputvalues ) ) {
            alert(gstinformat.test( inputvalues ));
            return true;
        } else {
            $( ".txt_gst_error" ).addClass( "error" );
            $( ".txt_gst_error" ).text( "Please Enter Valid GSTIN Number" );
            $( ".gstinnumber" ).val( '' );
            $( ".gstinnumber" ).focus();
        }
    });
    
    $( document ).on( "submit", "#frm_signup", function (){
        // e.preventDefault();
        var act = 'add_user';
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data:       'action=' +  act + '&' + $( "#frm_signup" ).serialize(),
            async:      false,
            success:    function ( data ) {
                var decode_data = JSON.parse( data );
                if( decode_data['success_flag'] == true ){
                    $( ".err_log" ).text( decode_data['message'] );
                    redirect_to_URL( decode_data['redirect'] );
                }  else {
                    $( ".err_log" ).text( decode_data['message'] );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        return false;
    }); 
    
    var reg_validator = $( "#frm_login" ).validate({
        onsubmit: true,
        rules: {
            txt_password: {
                required: true,
                minlength: 6,
                maxlength: 16
            },
            txt_phone_no: {
                required: true
            },
        },
    });
    
    $( document ).on( "submit", "#frm_login", function (){
        var act = 'user_login';
        var txt_phone_no = $( "#txt_phone_no" ).val();
        var txt_password = $( "#txt_password" ).val();
        var raw_data = {
            'action' : act,
            'txt_phone_no' : txt_phone_no,
            'txt_password' : txt_password
        };
        var send_data = enc( raw_data );
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data: {
                        enc_data: send_data
                    },
            async:      false,
            success:    function ( data ) {
                var decode_data = dec( data );
                if( decode_data['success_flag'] == true ){
                    redirect_to_URL( decode_data['redirect'] );
                }  else {
                    swal( "", decode_data['message'], "warning" );
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
        return false;
    }); 
    
    
    //Registration Box Effect

    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    
    var arr_first_el_valid = [
        '#txt_full_name', 
        '#txt_phone_no'
    ];
    
    var arr_first_select_valid = [
        '#dl_user_type'
    ];
    set_on_blur_validation( arr_first_el_valid, is_blank );
    set_on_blur_validation( arr_first_select_valid, is_selected );
    
    //press enter security password on text ..
    jQuery('#btn_signup_step_first').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            e.preventDefault();
            alert("hii");
        }
    });
    
    $( document ).on( "click", "#btn_signup_step_first", function (e){
        e.preventDefault();
        var full_name = $( "#txt_full_name" ).val();
        var phone_no = $( "#txt_phone_no" ).val();
        var user_type = $( "#dl_user_type" ).val();
        var term_policy = $("#checkbox-1").prop('checked');
        var act = 'signup_first_step';
        flag = true;
        check_validation( arr_first_el_valid, is_blank );
        check_validation( arr_first_select_valid, is_selected );
        validate_length( "#txt_phone_no", 10, 10 );
        set_only_alphabets( "#txt_full_name" );
        
        var raw_data = {
            'action' : act,
            'full_name' : full_name,
            'user_type' : user_type,
            'phone_no' : phone_no
        };
        var current_event = $( this );
        var send_data = enc( raw_data );
        if ( flag == true && term_policy == true ){
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data: {
                        enc_data: send_data
                    },
                async:      false,
                success:    function ( data ) {
                        var decode_data = dec( data );
                        if( decode_data['success_flag'] == true ){
                            $( ".get-number" ).text( "+91" + phone_no );
                            next_signup( current_event );
                        } else { 
                            swal("", decode_data['message'], "warning");
                            return false;
                        }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
        } else {
            $( ".check_terms" ).after( '<p style="color:red;" class="error err_upload_pic">Please Accept Terms and Condition<p>' );
            return false;
	    }
    });
    
     $( document ).on( "blur", "#txt_otp_no", function(){    
        validate_length( "#txt_otp_no", 4, 4 );
    });
    
    $( document ).on( "click", "#btn_signup_step_second", function (){
        var otp_no = $( "#txt_otp_no" ).val();
        var phone_no = $( "#txt_phone_no" ).val();
        var act = 'signup_step_second';
        var raw_data = {
            'action' : act,
            'otp_no' : otp_no
        };
        var current_event = $( this );
        flag = true;
        is_blank( "#txt_otp_no" );
        validate_length( "#txt_otp_no", 4, 4 );
        var send_data = enc( raw_data );
        if ( flag == true ){
            $.ajax({
                type:       "POST",
                dataType:   "html",
                url:        USER_AJAX_URL,
                data: {
                            enc_data: send_data
                    },
                async:      false,
                success:    function ( data ) {
                    var decode_data = dec( data );
                    if( decode_data['success_flag'] == true ){
                        next_signup( current_event );
                    } else {
                        swal( "", decode_data['message'], "success" );
                        return false;
                    }
                },
                error: function ( jqXHR, textStatus, errorThrown ) {
                    console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
                }
            });
        }
    });
    
    $( document ).on( "click", "#resend_otp", function (){
        var otp_no = $( "#txt_otp_no" ).val();
        var phone_no = $( "#txt_phone_no" ).val();
        var act = 'signup_resend_otp';
        var raw_data = {
            'action' : act,
            'otp_no' : otp_no,
            'phone_no' : phone_no
        };
        var send_data = enc( raw_data );
        $.ajax({
            type:       "POST",
            dataType:   "html",
            url:        USER_AJAX_URL,
            data: {
                        enc_data: send_data
                },
            async:      false,
            success:    function ( data ) {
                var decode_data = dec( data );
                if( decode_data['success_flag'] == true ){
                    swal( "", decode_data['message'], "success" );
                } else {
                    swal( "", decode_data['message'], "warning" );
                    return false;
                }
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
    }); 
    
    function next_signup( this_event ){
        if ( animating )
            return false;
        animating = true;
        current_fs = this_event.parents( '.form-wrap-li' );

        next_fs = this_event.parents( '.form-wrap-li' ).next();

        //show the next fieldset
        next_fs.show();

        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function (now, mx) {

                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;

                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";

                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;

                current_fs.css({
                    'transform': 'scale(' + scale + ')',
                    'position': 'absolute'
                });
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 800,
            complete: function () {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    }
})(jQuery);

