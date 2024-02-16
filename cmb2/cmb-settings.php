<?php

add_action('cmb2_admin_init', 'wt_register_theme_options_metabox');
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function wt_register_theme_options_metabox()
{

    /**
     * Registers options page menu item and form.
     */
    $cmb_options = new_cmb2_box(array(
        'id'           => 'wt_theme_options_page',
        'title'        => esc_html__('Configurações Wantyee', 'wt'),
        'object_types' => array('options-page'),

        /*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

        'option_key'      => 'wt_theme_options', // The option key and admin menu page slug.
        'icon_url'        => 'dashicons-admin-generic', // Menu icon. Only applicable if 'parent_slug' is left empty.
        // 'menu_title'              => esc_html__( 'Options', 'wt' ), // Falls back to 'title' (above).
        // 'parent_slug'             => 'themes.php', // Make options page a submenu item of the themes menu.
        // 'capability'              => 'manage_options', // Cap required to view options-page.
        // 'position'                => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
        // 'admin_menu_hook'         => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
        // 'priority'                => 10, // Define the page-registration admin menu hook priority.
        // 'display_cb'              => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
        // 'save_button'             => esc_html__( 'Save Theme Options', 'wt' ), // The text for the options-page save button. Defaults to 'Save'.
        // 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
        // 'message_cb'              => 'wt_options_page_message_callback',
        // 'tab_group'               => '', // Tab-group identifier, enables options page tab navigation.
        // 'tab_title'               => null, // Falls back to 'title' (above).
        // 'autoload'                => false, // Defaults to true, the options-page option will be autloaded.
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Página de login', 'wt'),
        'id'      => 'wt_login_page',
        'type'    => 'select',
        'options' => function () {
            $pages = wt_get_pages();
            $array = [];
            $array[''] = __('Selecione uma página', 'wt');
            foreach ($pages as $id => $title) {
                $array[$id] = $title;
            }
            return $array;
        },
        'required'      => true
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Página de cadastro de novo usuário', 'wt'),
        'id'      => 'wt_new_user_page',
        'type'    => 'select',
        'options' => function () {
            $pages = wt_get_pages();
            $array = [];
            $array[''] = __('Selecione uma página', 'wt');
            foreach ($pages as $id => $title) {
                $array[$id] = $title;
            }
            return $array;
        },
        'required'      => true
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Página de senha perdida', 'wt'),
        'id'      => 'wt_lostpassword_page',
        'type'    => 'select',
        'options' => function () {
            $pages = wt_get_pages();
            $array = [];
            $array[''] = __('Selecione uma página', 'wt');
            foreach ($pages as $id => $title) {
                $array[$id] = $title;
            }
            return $array;
        },
        'required'      => true
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Página de redefinição de senha', 'wt'),
        'id'      => 'wt_resetpassword_page',
        'type'    => 'select',
        'options' => function () {
            $pages = wt_get_pages();
            $array = [];
            $array[''] = __('Selecione uma página', 'wt');
            foreach ($pages as $id => $title) {
                $array[$id] = $title;
            }
            return $array;
        },
        'required'      => true
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Página da conta do usuário', 'wt'),
        'id'      => 'wt_account_page',
        'type'    => 'select',
        'options' => function () {
            $pages = wt_get_pages();
            $array = [];
            $array[''] = __('Selecione uma página', 'wt');
            foreach ($pages as $id => $title) {
                $array[$id] = $title;
            }
            return $array;
        },
        'required'      => true
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Página de edição/criação do anúncio', 'wt'),
        'id'      => 'wt_edit_anuncio_page',
        'type'    => 'select',
        'options' => function () {
            $pages = wt_get_pages();
            $array = [];
            $array[''] = __('Selecione uma página', 'wt');
            foreach ($pages as $id => $title) {
                $array[$id] = $title;
            }
            return $array;
        },
        'required'      => true
    ));

    $cmb_options->add_field(array(
        'name'    => esc_html__('Página de configuração de Categorias do Anúncio', 'wt'),
        'id'      => 'wt_categorias_settings_page',
        'type'    => 'select',
        'options' => function () {
            $pages = wt_get_pages();
            $array = [];
            $array[''] = __('Selecione uma página', 'wt');
            foreach ($pages as $id => $title) {
                $array[$id] = $title;
            }
            return $array;
        },
        'required'      => true
    ));

    $cmb_options->add_field(array(
        'name' => esc_html__('Imagem padrão', 'cmb2'),
        'desc' => esc_html__('A imagem padrão será exibido quando o comprador não definir uma imagem para o anúncio.', 'cmb2'),
        'id'   => 'wt_anuncio_default_image',
        'type' => 'file',
        'attributes' => array(
            'accept' => '.jpg,.jpeg,.png'
        )
    ));
}
