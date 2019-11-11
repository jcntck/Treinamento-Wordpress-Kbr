<?php

add_theme_support('post-thumbnails');

function pc_remove_links_menu()
{

    global $menu;

    remove_menu_page('index.php'); //Dashboard
    remove_menu_page('edit.php'); // Posts
    remove_menu_page('edit-comments.php'); // Comentários
    // remove_menu_page('plugins.php'); // Plugins
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

// Tentativa de colocar o jquery mask
function my_admin_enqueue_scripts()
{
    wp_enqueue_script('mask-js', get_template_directory_uri() . '/js/mask/dist/jquery.mask.min.js');
    wp_enqueue_script('my-admin-js', get_template_directory_uri() . '/js/functions.js', array(), '1.0.0', true);
}

add_action('acf/input/admin_enqueue_scripts', 'my_admin_enqueue_scripts');

function cadastrarInscrito()
{
    global $wpdb;
    $success = $wpdb->insert(
        'wp_inscritos',
        array(
            'nome_completo' => $_POST['nome_completo'],
            'data_nascimento' => date_converter($_POST['data_nascimento']),
            'cpf' => just_number($_POST['cpf']),
            'email' => $_POST['email'],
            'telefone' => just_number($_POST['telefone']),
            'celular' => just_number($_POST['celular']),
            'cep' => just_number($_POST['cep']),
            'endereco' => $_POST['endereco'],
            'bairro' => $_POST['bairro'],
            'cidade' => $_POST['cidade'],
            'estado' => $_POST['estado'],
            'treinamento_id' => $_POST['treinamento_id']
        )
    );

    if(!$success) {
        return new WP_Error('error', 'Não foi possível realizar seu cadastro, tente novamente mais tarde');
    }
}

function date_converter($_date = null)
{
    $format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
    if ($_date != null && preg_match($format, $_date, $partes)) {
        return $partes[3] . '-' . $partes[2] . '-' . $partes[1];
    }
    return false;
}

function just_number($number)
{
    return preg_replace('/\D/', '', $number);
}

function materialize_scripts() {
    wp_enqueue_style( 'style-name', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css' );
}
add_action('wp_enqueue_scripts', 'materialize_scripts');

function inscritos_admin() {
    add_menu_page('Listagem de inscritos', 'Inscritos', 'manage_options','inscritos_menu', 'inscritos_admin_page', 'dashicons-admin-users', 6 );
}

add_action('admin_menu', 'inscritos_admin');

function inscritos_admin_page() {
    include_once('inscritos_admin.php');
}

function getInscritos($id) {
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM wp_inscritos WHERE ID = " . $id);
    return json_encode($results);
}
