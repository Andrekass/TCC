//VÁLIDA SENHA 
$( document ).ready(function(){
    $('#form-senha').validate({
        rules:{
            csenha:{
                equalTo:"#senha"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element){
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element){
            if(element.parent('.input-group').length){
                error.insertAfter(element.parent());
            }else{
                error.insertAfter(element);
            }
        }
    })
});

//MOSTRA SENHA
$(function() {
    $('#password').password().on('show.bs.password', function(e) {
        $('#eventLog').text('On show event');
        $('#methods').prop('checked', true);
    }).on('hide.bs.password', function(e) {
        $('#eventLog').text('On hide event');
        $('#methods').prop('checked', false);
    });
    $('#methods').click(function() {
        $('#password').password('toggle');
    });
});