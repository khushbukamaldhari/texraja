

jQuery(document).ready(function () {
    var fixedTable1 = fixTable(document.getElementById('fixed-table-container'));
    if ($(window).width() >= 1023) {
        jQuery('.tr-click-all').click(function () {
            jQuery('body').toggleClass('show-menu');
        });
    }
    $(function () {
        $(".product_list tr").hover(function () {
            $(this).addClass("active-edit");
        }, function () {
            $(this).removeClass("active-edit");
        });
    });


    //profile
    jQuery('.toggle-menu').on('click', function () {
        jQuery('body').toggleClass('show-left');
    });

    jQuery('.tr-common-line').click(function () {
        if (jQuery(this).hasClass('open')) {
            jQuery(this).removeClass('open');
        } else {
            jQuery('.tr-common-line.open').removeClass('open');
            jQuery(this).addClass('open');
        }
    });

    jQuery('.tr-m-icon').click(function () {
        jQuery('body').toggleClass('show-search');
    });


    jQuery(window).scroll(function () {
        var sticky = jQuery('#header'),
                scroll = jQuery(window).scrollTop();

        if (scroll >= 70)
            sticky.addClass('fixed');
        else
            sticky.removeClass('fixed');
    });

    // Bottom-top
    jQuery("#myBtn").hide();
    jQuery(function () {
        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > 100) {
                jQuery('#myBtn').fadeIn();
            } else {
                jQuery('#myBtn').fadeOut();
            }
        });

        // scroll body to 0px on click
        jQuery('#myBtn').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 1000);
            return false;
        });
    });

    /*----------------------------------------
     Upload btn
     ------------------------------------------*/

    var SITE = SITE || {};

    SITE.fileInputs = function () {
        var $this = $(this),
                $val = $this.val(),
                valArray = $val.split('\\'),
                newVal = valArray[valArray.length - 1],
                $button = $this.siblings('.btn'),
                $fakeFile = $this.siblings('.file-holder');
        if (newVal !== '') {
            $button.text('Photo Chosen');
            if ($fakeFile.length === 0) {
                $button.after('<span class="file-holder">' + newVal + '</span>');
            } else {
                $fakeFile.text(newVal);
            }
        }
    };


    $('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var tmppath = URL.createObjectURL(event.target.files[0]);

            reader.onload = function (e) {
                $('#img-uploaded').attr('src', e.target.result);
                $('input.img-path').val(tmppath);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".uploader").change(function () {
        readURL(this);
    });


    //custom select only
    $('select').each(function () {
        var $this = $(this), numberOfOptions = $(this).children('option').length;

        $this.addClass('select-hidden');
        $this.wrap('<div class="select"></div>');
        $this.after('<div class="select-styled"></div>');

        var $styledSelect = $this.next('div.select-styled');
        $styledSelect.text($this.children('option').eq(0).text());

        var $list = $('<ul />', {
            'class': 'select-options'
        }).insertAfter($styledSelect);

        for (var i = 0; i < numberOfOptions; i++) {
            $('<li />', {
                text: $this.children('option').eq(i).text(),
                rel: $this.children('option').eq(i).val()
            }).appendTo($list);
        }

        var $listItems = $list.children('li');

        $styledSelect.click(function (e) {
            e.stopPropagation();
            $('div.select-styled.active').not(this).each(function () {
                $(this).removeClass('active').next('ul.select-options').hide();
            });
            $(this).toggleClass('active').next('ul.select-options').toggle();
        });

        $listItems.click(function (e) {
            e.stopPropagation();
            $styledSelect.text($(this).text()).removeClass('active');
            $this.val($(this).attr('rel'));
            $list.hide();
            //console.log($this.val());
        });

        $(document).click(function () {
            $styledSelect.removeClass('active');
            $list.hide();
        });

    });
});		