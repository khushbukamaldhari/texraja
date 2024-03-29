



// Custom Number Button

jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up"><i class="fa fa-caret-up" aria-hidden="true"></i></div><div class="quantity-button quantity-down"><i class="fa fa-caret-down" aria-hidden="true"></i></div></div>').insertAfter('.quantity input');
jQuery('.quantity').each(function () {
    var spinner = jQuery(this),
            input = spinner.find('.custom-number'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

    btnUp.click(function () {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });

    btnDown.click(function () {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
            var newVal = oldValue;
        } else {
            var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
    });
});

$(document).ready(function () {
    $(".advance-top").click(function () {
        $(".advane-bottom").toggleClass("open");
    });
   
});

