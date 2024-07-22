jQuery(document).ready(function($) {
    console.log("Script iniciado.");

    // Verifica se a tag <style> com o ID 'dynamic-styles' já existe; se não, cria e adiciona ao <head>
    var styleTag = $('#dynamic-styles');
    if (styleTag.length === 0) {
        styleTag = $('<style id="dynamic-styles"></style>');
        $('head').append(styleTag);
        console.log("Tag <style> criada e adicionada ao <head>.");
    }

    // Objeto para armazenar os estilos CSS aplicados
    var appliedStyles = {};

    // Função para carregar e aplicar as configurações de cores salvas
    function loadSavedColors() {
        var savedColors = easyfy_admin_colors_settings;
        console.log("Cores salvas carregadas: ", savedColors);
        if (savedColors) {
            for (var colorName in savedColors) {
                var color = savedColors[colorName];
                var elementId = 'easyfy_admin_colors_settings[' + colorName + ']';
                updateStyles(elementId, color);
            }
            styleTag.text(generateCompleteStyles());
            console.log("Estilos iniciais aplicados.");
        }
    }

    // Configura os color pickers e adiciona manipuladores de eventos para mudanças e limpeza de cores
    $('.color-picker').each(function() {
        $(this).wpColorPicker({
            change: function(event, ui) {
                var color = ui.color.toString();
                var id = $(this).attr('id');
                console.log(`Mudança detectada no picker ${id}: ${color}`);
                updateStyles(id, color);
                styleTag.text(generateCompleteStyles());
            },
            clear: function() {
                var id = $(this).attr('id');
                console.log(`Cor limpa no picker ${id}`);
                updateStyles(id, '');
                styleTag.text(generateCompleteStyles());
            }
        });
    });

    // Atualiza os estilos conforme os IDs dos color pickers e as cores selecionadas
    function updateStyles(id, color) {
        console.log(`Atualizando estilos para ${id} com a cor ${color}`);
        // Certifica-se de que o ID esteja no formato esperado para o switch
        if (!id.includes('easyfy_admin_colors_settings[')) {
            id = 'easyfy_admin_colors_settings[' + id + ']';
        }
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

    // Gera a string completa de estilos CSS com base nos estilos aplicados e os retorna
    function generateCompleteStyles() {
        var styles = '';
        for (var selector in appliedStyles) {
            if (appliedStyles.hasOwnProperty(selector) && appliedStyles[selector] !== '') {
                styles += selector + ' { ' + appliedStyles[selector] + ' }';
            }
        }
        return styles;
    }

    // Inicia o carregamento das cores configuradas
    loadSavedColors();
});
