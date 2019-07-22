var ERR_AJAX = "Something went wrong!!! Please try again...";
var ERR_BLANK_FORM = "Please Fill All the Required Fields...";
var SUBDIR = '/webcase/texraja/';
var FRONT_URL = window.location.protocol + "//" + window.location.host + SUBDIR;
var SERVER = window.location.protocol + '//' + window.location.host;
var flag = true;
var USER_AJAX_URL = SERVER + SUBDIR + "user_ajax";
var USER_URL = SERVER + SUBDIR + "core/user.php";
var ADMIN_AJAX_URL = SERVER + SUBDIR + "admin/admin_ajax";
var IMAGE_URL = SERVER + SUBDIR + "/assets/images";
var GLOBAL_VAR;
function clear_element( element ) {
    jQuery( element ).attr( 'value', "" );
}

function hide_loader() {
    $( ".loader" ).removeClass( 'show' );
}

function show_loader() {
    $( ".loader" ).addClass( 'show' );
}
function remove_loader() {
    $( ".mm" ).removeClass( 'loader' );
    $( ".send_change_password_link" ).removeClass( 'loader' );
}

var enc = function ( raw_data, is_json = true ) {
    if ( is_json == true ) {
        var enc_data = CryptoJS.AES.encrypt( JSON.stringify( raw_data ), GLOBAL_VAR.ENC_KEY, { format: CryptoJSAesJson } ).toString();
    } else {
        var enc_data = CryptoJS.AES.encrypt( raw_data, "" , { format: CryptoJSAesJson } ).toString();
    }
    return enc_data;
};

var dec = function ( enc_data, is_json = true ) {
    if ( is_json == true ) {
        var dec_data = JSON.parse( CryptoJS.AES.decrypt( enc_data, GLOBAL_VAR.ENC_KEY, { format: CryptoJSAesJson } ).toString( CryptoJS.enc.Utf8 ) );
    } else {
        var dec_data = CryptoJS.AES.decrypt( enc_data, GLOBAL_VAR.ENC_KEY, { format: CryptoJSAesJson } ).toString( CryptoJS.enc.Utf8 );
    }
    return dec_data;
};

//Pass Only el Name
function is_selected(el){
    if ( jQuery( el + " option:selected" ).index() == 0)
    {
        invalid_input( el, true );
        flag = false;
    } else{
        invalid_input( el, false );
    }
}

function validate_length( el, min, max )
{  
    if (jQuery( el ).val().length < min || jQuery( el ).val().length > max)
    {
        invalid_input( el, true );
        flag = false;
    } else{
        invalid_input( el, false );
    }
}

function match_two_elements( el1, el2 )
{
    if ( jQuery( el1 ).val() != jQuery( el2).val() )
    {
        invalid_input( el2, true );
        flag = false;
    } else
    {
        invalid_input( el2, false );
    }
}

//To Reload current page
function reload_page() {
    window.location.reload();
    window.location.href = document.URL;
}

//To Redirect Page
function redirect_to_URL( REDIRECT_URL ) {
    window.location.href = REDIRECT_URL;
}

//To Reset Form
function reset_form( formId ) {
    jQuery( '#' + formId )[0].reset();
}

//Remove Errors
function remove_form_errors( formId ) {
    jQuery( '#' + formId + ' input' ).css( 'box-shadow', '0' );
    jQuery( '#' + formId + ' select' ).css( 'box-shadow', '0' );
    jQuery( '#' + formId + ' textarea' ).css( 'box-shadow', '0' );
}


//Apply CSS to Wrong Input
function invalid_input( el, vflag ) {
    if ( vflag ) {
        jQuery( el ).addClass( "input-err" );
    } else {
        jQuery( el ).removeClass( "input-err" );
    }
}

//Check Validation On Blur
function err_on_blur( el, fn ) {
    jQuery( el ).blur( function () {
        fn( el );
    });
}

//Set Validation on Multiple IDs
function check_validation( arrlst, func ) {
    jQuery.map( arrlst, function ( val ) {
        func( val );
    });
}

//Set Validation on Blur Event on Multiple IDs
function set_on_blur_validation( arrlst, func ) {
    jQuery.map( arrlst, function ( val ) {
        err_on_blur( val, func );
    });
}

//Check Blank Text Field
function is_blank( el ) {
    if ( jQuery.trim( jQuery( el ).val() ) == "" ) {
        invalid_input( el, true );
        flag = false;
    } else {
        invalid_input( el, false );
    }
}

//Email Validation
function is_email( el ) {
    if ( jQuery.trim( jQuery( el ).val() ) != "" ) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if ( !expr.test( jQuery.trim( jQuery( el ).val() ) ) ) {
            invalid_input( el, true );
            flag = false;
        } else {
            invalid_input( el, false );
        }
    } else {
        invalid_input( el, true );
    }
}

function set_only_alphabets( el ){
    jQuery( el ).keypress( function ( e ) {
        if ( e.which != 8 && e.which != 0 && e.which != 32 && ( e.which < 65 || e.which > 90 ) && ( e.which < 97 || e.which > 122 ) ) {
            return false;
        }
    });
}

function set_only_digits( el ){
    jQuery( el ).keypress( function ( e ) {
        if ( e.which != 8 && e.which != 0 && ( e.which < 48 || e.which > 57 ) ) {
            return false;
        }
    });
}

function set_only_price( el )
{
    jQuery( el ).keypress( function ( e ) {
        if ( e.which != 8 && e.which != 0 && e.which != 46 && ( e.which < 48 || e.which > 57 ) ) {
            return false;
        }
        if ( e.which == 46 && jQuery( el ).val().indexOf('.') > 0 ) {
            return false;
        }
    });
}

function set_values( data ){
    jQuery.each( data, function ( i, d ){
        $( "#" + i ).val( d );
    });
}

function set_text_values( data, type ){
    jQuery.each( data, function ( i, d ){
        jQuery( type + i ).text( d );
    });
}

function copyToClipboard( textToCopy ) {
    var $temp = $( "<input>" );
    $( "body" ).append( $temp );
    $temp.val( textToCopy ).select();
    document.execCommand( "copy" );
    $temp.remove();
}

function set_val( source, destination, event ){        
    jQuery( document ).on( event, source, function(){
        jQuery( destination ).val( jQuery( source ).val() );
    });
}

function scroll_to_focus( $toElement, $focusElement, $offset, $speed ){
    var $this = $( this ),
            $offset = $offset * 1 || 0,
            $speed = $speed * 1 || 500;
    $( 'html, body' ).animate({
        scrollTop: $( $toElement ).offset().top + $offset
    }, $speed );

    if ( $focusElement )
        $( $focusElement ).focus();
};

function readURL( input, output ) {
    if ( input.files && input.files[0] ) {
        var reader = new FileReader();
    reader.onload = function( e ) {
      $( output ).attr( 'src', e.target.result );
    }
    reader.readAsDataURL( input.files[0] );
    }
}

jQuery.fn.set_toggle = function () {
    if ( jQuery( this ).attr( 'checked' ) == undefined ) {
        jQuery( this ).attr( 'checked', true );
    } else {
        jQuery( this ).removeAttr( 'checked' );
    }
};

function removeItem_array(array, item){
    for(var i in array){
        if(array[i]==item){
            array.splice(i,1);
            break;
        }
    }
}

jQuery.fn.extend({
    autosuggestion: function( opt ) {
        var defaults = {
            call : '',
            wait : 1000,
            minwords : 0
        };
        var oldval = '';
        
        $this = jQuery( this );
        
        if( typeof opt == 'undefined' ){
            return;
        } else {
            var minwords = ( typeof opt.minwords != 'undefined' ) ? opt.minwords : defaults.minwords;
            var wait = ( typeof opt.wait != 'undefined' ) ? opt.wait : defaults.wait;
            
            oldval = $this.val();
            
            if( oldval.length < minwords ){
                return;
            }
            
            var fn = opt.call;
            if( typeof( opt.call ) === 'string' ){
                fn = window[opt.call];
            }
            
            setTimeout( function(){
                var newval = $this.val();
                if( oldval == newval ){
                    fn( $this, newval );
                }
            }, wait );
        }
        return this;
    }
});


var safe_ajax = function( opt ){
    if( typeof opt == 'undefined' ){
        return;
    } else {
        var defaults = {
            data : {},
            url : USER_AJAX_URL,
            minwords : 0
        };
        
        if( typeof opt.data == 'undefined' || typeof opt.callback == 'undefined' ){
            return;
        }
        
        var data = ( typeof opt.data != 'undefined' ) ? opt.data : defaults.data;
        var url = ( typeof opt.url != 'undefined' ) ? opt.url : defaults.url;
        var type = ( typeof opt.type != 'undefined' ) ? opt.type : defaults.type;
        var callback = ( typeof opt.callback != 'undefined' ) ? opt.callback : defaults.callback;
        var fn = callback;
        
        if( typeof( callback ) === 'string' ){
            fn = window[callback];
        }
                
        var enc_data = enc( data );
        
        jQuery.ajax({
            type:       "POST",
            dataType:   type,
            url:        url,
            data: {
                enc_data: enc_data
            },
            beforesend: function(){
                /* Triggered before sending. */
            },
            success:    function ( response ) {

            },
            complete:   function ( response, textStatus ) {
                var return_data;
                if( textStatus === 'success' ){
                        return_data = dec( response.responseText );
                } else {
                    return_data = response;
                }

                fn( return_data );
                return return_data;
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
    }
};

(function($){
    global_var();
    function global_var(){
         var str = 'action=global_var'
        $.ajax({
            type: "POST",
            dataType: "html",
            url: USER_AJAX_URL,
            data: str,
            async: false,
            success: function ( data ) {
//                console.log( data );
                var decode_data = JSON.parse( data );
                GLOBAL_VAR = decode_data;
            },
            error: function ( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR + " :: " + textStatus + " :: " + errorThrown );
            }
        });
    }
})(jQuery);

