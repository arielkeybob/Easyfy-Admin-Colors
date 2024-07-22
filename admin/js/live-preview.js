jQuery(document).ready(function($) {
    var styleTag = $('#dynamic-styles');
    if (styleTag.length === 0) {
        styleTag = $('<style id="dynamic-styles"></style>');
        $('head').append(styleTag);
    }

    var appliedStyles = {};

    // Função para carregar e aplicar as cores salvas
    function loadSavedColors() {
        var savedColors = easyfy_admin_colors_settings; // Usando a variável PHP local
        if (savedColors) {
            for (var colorName in savedColors) {
                var color = savedColors[colorName];
                var elementId = 'easyfy_admin_colors_settings[' + colorName + ']';
                updateStyles(elementId, color);
            }
            styleTag.text(generateCompleteStyles());
        }
    }

    $('.color-picker').each(function() {
        var id = $(this).attr('id');
        var color = $(this).val();
        updateStyles(id, color);
    }).wpColorPicker({
        change: function(event, ui) {
            var color = ui.color.toString();
            var id = $(this).attr('id');
            updateStyles(id, color);
            styleTag.text(generateCompleteStyles());
        },
        clear: function() {
            var id = $(this).attr('id');
            updateStyles(id, '');
            styleTag.text(generateCompleteStyles());
        }
    });

    function updateStyles(id, color) {
        switch(id) {
            case 'easyfy_admin_colors_settings[menu_text]':
                appliedStyles['#adminmenu a'] = 'color: ' + color + ' !important;';
                break;
            case 'easyfy_admin_colors_settings[base_menu]':
                appliedStyles['#adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap'] = 'background-color: ' + color + ' !important;';
                break;
            case 'easyfy_admin_colors_settings[highlight]':
                appliedStyles['#adminmenu li:hover > a, #adminmenu .wp-has-current-submenu > a, #adminmenu li.current a.menu-top'] = 'background-color: ' + color + ' !important;';
                break;
            case 'easyfy_admin_colors_settings[notification]':
                appliedStyles['#adminmenu .awaiting-mod, #adminmenu .update-plugins, .wp-core-ui .wp-ui-notification'] = 'background-color: ' + color + ' !important; color: #ffffff !important;';
                break;
            case 'easyfy_admin_colors_settings[background]':
                appliedStyles['#wpcontent, #wpfooter'] = 'background-color: ' + color + ' !important;';
                break;
            case 'easyfy_admin_colors_settings[links]':
                appliedStyles['#wpbody-content a, #wpbody a'] = 'color: ' + color + ' !important;';
                break;
            case 'easyfy_admin_colors_settings[buttons]':
                appliedStyles['.wp-core-ui .button:not(.wp-color-result), .wp-core-ui .button-primary:not(.wp-color-result)'] = 'background-color: ' + color + ' !important; border-color: ' + color + ' !important;';
                break;
            case 'easyfy_admin_colors_settings[form_inputs]':
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

    // Carrega as cores salvas ao inicializar
    loadSavedColors();
});
