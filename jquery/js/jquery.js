(function ($, Drupal, drupalSettings) {
    $(document).ready(function () {
        var $first = $('#same-firstname');
        var $last = $('.form-item-lastname');
        if($first.is(':checked')){
            $last.hide();
        }

        $first.on('change',function () {
        if ($(this).is(':checked')) {
            $last.hide();
        } else {
            $last.show();
        }
        });
    });



    Drupal.behaviors.MyModuleBehavior = {
        attach: function (context, settings) {
        var color_body = drupalSettings.jquery.color_body;
        alert(color_body)
        $('body').css('background', color_body);
        }
    };

})(jQuery, Drupal, drupalSettings);
