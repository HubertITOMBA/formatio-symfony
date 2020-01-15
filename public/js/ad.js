$('#add-image').click(function() {
    // Récupération du numéro des futures champs à créer
    const index = +$('#widgets-counter').val();

    //Récupération du prototype des entrées
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);

    //injection du prototy^pe de code au sein de la div
    // console.log(tmpl);
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    //Gérer le bouton Supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function() {
        const target = this.dataset.target;
        // console.log(target);
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#ad_images div.form-group').length;
    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();