jQuery(document).ready(function($) {
    var styleTag = $('#dynamic-styles');
    if (styleTag.length === 0) {
        styleTag = $('<style id="dynamic-styles"></style>');
        $('head').append(styleTag);
    }

    var appliedStyles = {};

    $('.color-picker').wpColorPicker({
        change: function(event, ui) {
            var color = ui.color.toString();
            var elementId = $(this).attr('id');

            updateStyles(elementId, color);

            styleTag.text(generateCompleteStyles());
        },
        clear: function() {
            var elementId = $(this).attr('id');

            updateStyles(elementId, '');

            styleTag.text(generateCompleteStyles());
        }
    });

    function updateStyles(id, color) {
        switch(id) {
            case 'menu_text_color':
                appliedStyles['#adminmenu a'] = 'color: ' + color + ' !important;';
                break;
            case 'base_menu_color':
                appliedStyles['#adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap'] = 'background-color: ' + color + ' !important;';
                break;
            case 'highlight_color':
                appliedStyles['#adminmenu li:hover > a, #adminmenu .wp-has-current-submenu > a, #adminmenu li.current a.menu-top'] = 'background-color: ' + color + ' !important;';
                break;
            case 'notification_color':
                appliedStyles['#adminmenu .awaiting-mod, #adminmenu .update-plugins, .wp-core-ui .wp-ui-notification'] = 'background-color: ' + color + ' !important; color: #ffffff !important;';
                break;
            case 'background_color':
                appliedStyles['#wpcontent, #wpfooter'] = 'background-color: ' + color + ' !important;';
                break;
            case 'links_color':
                appliedStyles['#wpbody-content a, #wpbody a'] = 'color: ' + color + ' !important;';
                break;
            case 'buttons_color':
                appliedStyles['.wp-core-ui .button:not(.wp-color-result), .wp-core-ui .button-primary:not(.wp-color-result)'] = 'background-color: ' + color + ' !important; border-color: ' + color + ' !important;';
                break;
            case 'form_inputs_color':
                appliedStyles['input[type="text"], input[type="search"], textarea'] = 'background-color: ' + color + ' !important;';
                break;
        }
    }

    function generateCompleteStyles() {
        var styles = '';
        for (var selector in appliedStyles) {
            if (appliedStyles.hasOwnProperty(selector) && appliedStyles[selector] !== '') {
                styles += selector + ' { ' + appliedStyles[selector] + ' }';
            }
        }
        return styles;
    }
});
