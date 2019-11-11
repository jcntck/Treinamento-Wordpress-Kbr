<?php materialize_scripts(); ?>
<!-- <h2>Listagem de inscritos</h1> -->

<?php
global $wpdb;
$results = $wpdb->get_results("SELECT * FROM wp_inscritos");

// var_dump($results);
if (!empty($results)) : ?>
    <section class="row">
        <table class="col">
            <thead>
                <tr>
                    <th>TREINAMENTO</th>
                    <th>NOME COMPLETO</th>
                    <th>DATA NASCIMENTO</th>
                    <th>E-MAIL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $inscrito) : ?>
                    <tr>
                        <td><?= get_the_title($inscrito->treinamento_id) ?></td>
                        <td><?= date('d/m/Y', strtotime($inscrito->data_nascimento)) ?></td>
                        <td><?= $inscrito->nome_completo ?></td>
                        <td><?= $inscrito->email ?></td>
                        <td><button class="btn-info" value="<?=$inscrito->ID?>">Mais informações</button></td>
                        <!-- <input type="hidden" id="id" value="<?=$inscrito->ID?>"> -->
                        <input type="hidden" id="info-<?=$inscrito->ID?>" value='<?= getInscritos($inscrito->ID) ?>''>
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

    $(".btn-info").click(function() {
        // console.log($(".btn-info").val())
        var id = $(this).val();
        var objInfo = JSON.parse($("#info-" + id).val());
        console.log(objInfo);
        if (display == false) {
            $('#mais-info').append("");
            display = true
        } else {
            $('#mais-info').empty();
            display = false;
        }
    })
</script>