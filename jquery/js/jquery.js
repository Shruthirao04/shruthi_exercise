(function ($) {
    $(document).ready(function () {
        var $first = $('#edit-firstname');
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
})(jQuery);


(function ($, Drupal, drupalSettings) {
    Drupal.behaviors.MyModuleBehavior = {
        attach: function (context, settings) {
        var testing = drupalSettings.shruthi_exercise.testing;
        alert(testing)
        $('body').css('background', testing);
        }
    };
    // Drupal.behaviors.MyModuleBehavior.attach(document, Drupal.settings);
})(jQuery, Drupal, drupalSettings);