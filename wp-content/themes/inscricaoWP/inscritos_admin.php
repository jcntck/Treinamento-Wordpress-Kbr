<?php datable_style(); ?>

<?php
global $wpdb;
if (isset($_POST['apagar'])) $message = apagarInscrito($_POST['apagar']);
if (isset($_GET['treinamento_id'])) $results = $wpdb->get_results("SELECT * FROM wp_inscritos WHERE treinamento_id=" . $_GET['treinamento_id']);
else $results = $wpdb->get_results("SELECT * FROM wp_inscritos");
?>
<style>
    #wpfooter {
        display: none;
    }
</style>
<h2>Listagem de inscritos</h2>
<div class="row" id="status-message">
    <?= $message ?>
</div>
<?php
// print_r($results);
if (!empty($results)) : ?>
    <main class="container-fluid">
        <section class="row">
            <div class="col">
                <table class="table table-striped" id="inscritos">
                    <thead>
                        <tr>
                            <th>TREINAMENTO</th>
                            <th>DATA DE INSCRIÇÃO</th>
                            <th>NOME COMPLETO</th>
                            <th>E-MAIL</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $inscrito) : ?>
                            <tr>
                                <td><?= get_the_title($inscrito->treinamento_id) ?></td>
                                <td><?= date('d/m/Y', strtotime($inscrito->created_at)) ?></td>
                                <td><?= $inscrito->nome_completo ?></td>
                                <td><?= $inscrito->email ?></td>
                                <td><?= $inscrito->status_transacao ? mostrarStatus($inscrito->status_transacao) : 'Gratuito' ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" value="<?= $inscrito->ID ?>">Mais informações</button>
                                    <form method="post" style="display: inline">
                                        <button class="btn btn-danger btn-sm" name="apagar" value="<?= $inscrito->ID ?>">Deletar</button>
                                    </form>

                                </td>
                                <!-- <input type="hidden" id="id" value="<?= $inscrito->ID ?>"> -->
                                <input type="hidden" id="info-<?= $inscrito->ID ?>" value='<?= getInscritos($inscrito->ID) ?>'>
                                <input type="hidden" id="treinamento-<?= $inscrito->ID ?>" value='<?= json_encode(carregarTreinamento($inscrito->treinamento_id)) ?>'>
                                <input type="hidden" id="status-<?= $inscrito->ID ?>" value="<?=mostrarStatus($inscrito->status_transacao)?>">
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </section>
        <section class="" id="mais-info"></section>
        </div>
    </main>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.20/datatables.min.js"></script>
<script src="<?= get_template_directory_uri() ?>/js/mask-admin.js"></script>
<script>
    var display = false;
    var currentId;

    $(".btn-info").click(function() {
        var id = $(this).val();
        var inscrito = JSON.parse($("#info-" + id).val());
        var treinamento = JSON.parse($("#treinamento-" + id).val());
        if (display == false) {
            $('#mais-info').append(mostrarDados(inscrito, treinamento));
            currentId = id;
            display = true
        } else {
            if (id != currentId) {
                $('#mais-info').empty();
                $('#mais-info').append(mostrarDados(inscrito, treinamento));
                currentId = id;
            } else {
                $('#mais-info').empty();
                display = false;
            }
        }
    })

    function mostrarDados(inscrito, treinamento) {
        return conteudo = "<div class='card col-12'><div class='card-header'>Mais informações</div><div class='card-body'>" +
            "<div class='row'><div class='col'><h5 class='card-title'>Nome completo: " + inscrito[0].nome_completo + "</h5></div></div>" +
            "<div class='row'><div class='col-4'><p class='card-text my-2'><strong>Data de nascimento:</strong> " + maskData(inscrito[0].data_nascimento) + "</p></div>" +
            "<div class='col-4'><p class='card-text my-2'><strong>CPF:</strong> " + maskCPF(inscrito[0].cpf) + "</p></div>" +
            "<div class='col-4'><p class='card-text my-2'><strong>E-mail:</strong> " + inscrito[0].email + "</p></div></div>" +
            "<div class='row border-bottom'><div class='col-4'><p class='card-text my-2'><strong>Telefone:</strong> " + maskTelefone(inscrito[0].telefone) + "</p></div>" +
            "<div class='col-4'><p class='card-text my-2'><strong>Celular:</strong> " + maskTelefone(inscrito[0].celular) + "</p></div></div>" +
            "<div class='row border-bottom'><div class='col-4'><p class='card-text my-2'><strong>CEP:</strong> " + maskCep(inscrito[0].cep) + "</p></div>" +
            "<div class='col'><p class='card-text my-2'><strong>Endereco:</strong> " + inscrito[0].endereco + ", " + inscrito[0].numero + " - " + inscrito[0].bairro + " - " + inscrito[0].cidade + " - " + inscrito[0].estado + " </p></div></div>" +
            "<div class='row'><div class='col-12 mt-3'><h6>Informações do treinamento</h6></div>"+
            "<div class='col'><p class='card-text my-2'><strong>"+ treinamento.wp.post_title +"</strong></p></div>" +
            "<div class='col'><p class='card-text my-2'><strong>Data de inscrição:</strong> "+maskData(inscrito[0].created_at)+" </p></div>" +
            "<div class='col'><p class='card-text my-2'><strong>Valor do treinamento:</strong> "+(treinamento.acf.gratuito == 'true' ? 'Gratuito' : 'R$ ' + treinamento.acf.valor.replace('.', ',') )+"</p></div>" +
            "<div class='col'><p class='card-text my-2'><strong>Status:</strong> "+(inscrito[0].status_transacao ? $('#status-'+inscrito[0].ID).val() : '-' )+" </p></div></div>" +
            "</div></div>";
    }

    function fecharMessagem() {
        $("#status-message").empty();
    }

    $(document).ready(function() {
        $('#inscritos').DataTable({
            "order": [],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
            },
            "pageLength": 10,
            "lengthChange": false,
            "lengthMenu": [-1]
        });
    });
</script>