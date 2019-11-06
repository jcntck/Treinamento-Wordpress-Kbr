acf.add_action('ready', function($el) {
    var field = $('#acf-field_5dc2f9bb71652');
    $(field).mask('0000.00', { reverse: true });
});