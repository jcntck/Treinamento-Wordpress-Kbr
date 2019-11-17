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

/* Registrando menu de navegação */

function registrar_menu_navegacao()
{
    register_nav_menu('header-menu', 'Menu Header');
}

add_action('init', 'registrar_menu_navegacao');

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

function my_admin_enqueue_scripts()
{
    wp_enqueue_script('mask-js', get_template_directory_uri() . '/js/mask/dist/jquery.mask.min.js');
    wp_enqueue_script('my-admin-js', get_template_directory_uri() . '/js/functions.js', array(), '1.0.0', true);
}

add_action('acf/input/admin_enqueue_scripts', 'my_admin_enqueue_scripts');

function carregarTreinamento($id)
{
    $treinamento['acf'] = get_fields($id) ? get_fields($id) : null;
    $treinamento['wp'] = $id ? get_post($id) : null;
    $treinamento['thumb'] = get_the_post_thumbnail($id, 'thumbnail', array('class' => 'circle'));
    return $treinamento;
}

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

    if ($success) {
        $vagasBanco = $wpdb->get_row("SELECT meta_value FROM wp_postmeta WHERE meta_key='vagas' AND post_id=" . $_POST['treinamento_id']);
        $vagas = $vagasBanco->meta_value - 1;
        $wpdb->update('wp_postmeta', array( 'meta_value' => $vagas), array('meta_key' => 'vagas', 'post_id' => $_POST['treinamento_id']));
        return true;
    } else return false;
}

function getInscritos($id)
{
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM wp_inscritos WHERE ID = " . $id);
    return json_encode($results);
}

function apagarInscrito($id)
{
    global $wpdb;
    $status = $wpdb->delete("wp_inscritos", array('ID' => $id), array('%d'));

    if ($status) {
        return '<div class="col s11 card-panel red accent-1"> <p> Inscrito deletado <a href="#" onclick="fecharMessagem()">Fechar</a></p>  </div>';
    } else {
        return '<div class="col s11 card-panel red accent-1"> <p> Não foi possível deletar esse inscrito. Tente novamente mais tarde. <a href="#" onclick="fecharMessagem()">Fechar</a></p>  </div>';
    }
}

function validateCPF()
{
    global $wpdb;
    if (isset($_POST['cpf'])) {
        $rows = $wpdb->get_results("SELECT * FROM wp_inscritos WHERE cpf=" . just_number($_POST['cpf']) . " AND treinamento_id=" . $_POST['treinamento_id'], ARRAY_N);
        $nums_rows = $wpdb->num_rows;
        if ($nums_rows > 0) return false;
        else return true;
    } else {
        return false;
    }
}

function validateEmail()
{
    global $wpdb;
    if (isset($_POST['email'])) {
        $rows = $wpdb->get_results("SELECT * FROM wp_inscritos WHERE email='" . $_POST['email'] . "' AND treinamento_id=" . $_POST['treinamento_id'], ARRAY_N);
        $nums_rows = $wpdb->num_rows;
        if ($nums_rows > 0) return false;
        else return true;
    } else {
        return false;
    }
}

function saveInputsValue()
{
    if (isset($_SESSION['errorCPF']) && isset($_SESSION['errorEmail'])) {
        $dados = array(
            'nome_completo' => $_POST['nome_completo'],
            'data_nascimento' => $_POST['data_nascimento'],
            'telefone' => $_POST['telefone'],
            'celular' => $_POST['celular'],
            'cep' => $_POST['cep'],
            'endereco' => $_POST['endereco'],
            'bairro' => $_POST['bairro'],
            'cidade' => $_POST['cidade'],
            'estado' => $_POST['estado']
        );
    } else if (isset($_SESSION['errorCPF'])) {
        $dados = array(
            'nome_completo' => $_POST['nome_completo'],
            'data_nascimento' => $_POST['data_nascimento'],
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone'],
            'celular' => $_POST['celular'],
            'cep' => $_POST['cep'],
            'endereco' => $_POST['endereco'],
            'bairro' => $_POST['bairro'],
            'cidade' => $_POST['cidade'],
            'estado' => $_POST['estado']
        );
    } else if (isset($_SESSION['errorEmail'])) {
        $dados = array(
            'nome_completo' => $_POST['nome_completo'],
            'data_nascimento' => $_POST['data_nascimento'],
            'cpf' => $_POST['cpf'],
            'telefone' => $_POST['telefone'],
            'celular' => $_POST['celular'],
            'cep' => $_POST['cep'],
            'endereco' => $_POST['endereco'],
            'bairro' => $_POST['bairro'],
            'cidade' => $_POST['cidade'],
            'estado' => $_POST['estado']
        );
    }
    $_SESSION['inputs'] = $dados;
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

// Admin - Inscritos

function materialize_scripts()
{
    wp_enqueue_style('style-name', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css');
}
add_action('wp_enqueue_scripts', 'materialize_scripts');

function inscritos_admin()
{
    add_menu_page('Listagem de inscritos', 'Inscritos', 'manage_options', 'inscritos_menu', 'inscritos_admin_page', 'dashicons-admin-users', 6);
}

add_action('admin_menu', 'inscritos_admin');

function inscritos_admin_page()
{
    include_once('inscritos_admin.php');
}

add_filter('manage_treinamento_posts_columns', 'posts_columns');
add_action('manage_treinamento_posts_custom_column', 'inscritos_columns_content', 10, 2);

function posts_columns($defaults)
{
    $defaults = array(
        'cb' => '&lt;input type="checkbox">',
        'title' => __('Treinamentos'),
        'inscritos' => __('Inscritos'),
        'date' => __('Date')
    );
    return $defaults;
}

function inscritos_columns_content($column_name, $post_ID)
{
    if ($column_name === 'inscritos') {
        echo '<a href="' . site_url() . '/wp-admin/admin.php?page=inscritos_menu&treinamento_id=' . $post_ID . '">Inscritos</a>';
    }
}
