<?php materialize_scripts(); ?>

<?php
global $wpdb;
if(isset($_POST['apagar'])) $message = apagarInscrito($_POST['apagar']);
if(isset($_GET['treinamento_id'])) $results = $wpdb->get_results("SELECT * FROM wp_inscritos WHERE treinamento_id=". $_GET['treinamento_id']);
else $results = $wpdb->get_results("SELECT * FROM wp_inscritos");
?>
<!-- <h2>Listagem de inscritos</h2> -->
<div class="row" id="status-message">
    <?=$message?>
</div>
<?php
// var_dump($results);
if (!empty($results)) : ?>
    <section class="row">
        <table class="col">
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
                        <td> - </td>
                        <td>
                            <button class="btn-info" value="<?= $inscrito->ID ?>">Mais informações</button>
                            <form method="post" style="display: inline">
                                <button name="apagar" value="<?= $inscrito->ID ?>">Deletar</button>
                            </form>

                        </td>
                        <!-- <input type="hidden" id="id" value="<?= $inscrito->ID ?>"> -->
                        <input type="hidden" id="info-<?= $inscrito->ID ?>" value='<?= getInscritos($inscrito->ID) ?>'>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <section id="mais-info" class="row">

    </section>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    var display = false;
    var currentId;

    $(".btn-info").click(function() {
        var id = $(this).val();
        var inscrito = JSON.parse($("#info-" + id).val());
        // console.log(inscrito)
        if (display == false) {
            $(' #mais-info').append(mostrarDados(inscrito));
            currentId = id;
            display = true
        } else {
            if (id != currentId) {
                $('#mais-info').empty();
                $('#mais-info').append(mostrarDados(inscrito));
                currentId = id;
            } else {
                $('#mais-info').empty();
                display = false;
            }
        }
    })

    function mostrarDados(inscrito) {
        return conteudo = "<p>" + inscrito[0].nome_completo + "</p>" +
            "<p>" + inscrito[0].data_nascimento + "</p>" +
            "<p>" + inscrito[0].cpf + "</p>" +
            "<p>" + inscrito[0].email + "</p>" +
            "<p>" + inscrito[0].telefone + "</p>" +
            "<p>" + inscrito[0].celular + "</p>";
    }

    function fecharMessagem() {
        $("#status-message").empty();
    }
</script>