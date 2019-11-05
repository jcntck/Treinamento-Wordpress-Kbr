<?php

add_theme_support('post-thumbnails');

function pc_remove_links_menu()
{

    global $menu;

    remove_menu_page('index.php'); //Dashboard
    remove_menu_page('edit.php'); // Posts
    remove_menu_page('edit-comments.php'); // Comentários
    remove_menu_page('plugins.php'); // Plugins
    remove_menu_page('tools.php');  // Ferramentas
    // remove_menu_page ('upload.php'); // Mídia
    // remove_menu_page ('link-manager.php'); // Links Permanentes
    // remove_menu_page ('options-general.php');  // Configurações

}
add_action('admin_menu', 'pc_remove_links_menu');

function pc_create_post_treinamento()
{
    $singularName = 'Treinamento';
    $pluralName = 'Treinamentos';

    $labels = array(
        'name' => $pluralName,
        'singular_name' => $singularName,
        'add_new_item' => 'Adcionar ' . $singularName,
        'edit_item' => 'Editar ' . $singularName,
        'new_item' => 'Novo ' . $singularName,
        'view_item' => 'Visualizar ' . $singularName,
        'view_items' => 'Visualizar ' . $pluralName,
        'item_published' => $singularName . ' publicado.',
        'item_updated' => $singularName . ' atualizado'
    );

    $supports = array(
        'title',
        'editor',
        'thumbnail'
    );

    $args = array(
        'public' => true,
        'labels' => $labels,
        'description' => 'Treinamentos disponíveis para as pessoas.',
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => $supports
    );

    register_post_type('treinamento', $args);
}
add_action('init', 'pc_create_post_treinamento');

function wordpress_pagination($items = null)
{
    $prev_arrow = is_rtl() ? '→' : '←';
    $next_arrow = is_rtl() ? '←' : '→';

    global $wp_query;
    if ($items) {
        $total = $items->max_num_pages;
    } else {
        $total = $wp_query->max_num_pages;
    }
    $big = 999999999; // need an unlikely integer
    if ($total >= 1) {
        if (!$current_page = get_query_var('paged'))
            $current_page = 1;
        if (get_option('permalink_structure')) {
            $format = 'page/%#%/';
        } else {
            $format = '&paged=%#%';
        }
        echo paginate_links(array(
            'base'            => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'        => $format,
            'current'        => max(1, get_query_var('paged')),
            'total'         => $total,
            'type'             => 'list',
            'prev_text'        => $prev_arrow,
            'next_text'        => $next_arrow,
        ));
    }
}

function show_opcoes_treinamento()
{
    require_once('meta/meta_data_treinamentos.php');
}

function add_treinamento_box()
{
    add_meta_box('meta_treinamento', 'Opções de Adcionais', 'show_opcoes_treinamento');
}
add_action('add_meta_boxes', 'add_treinamento_box');
