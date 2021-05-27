$(function(){

    // Mask Configurations
    var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
    },
    spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

	$('.phone').mask(SPMaskBehavior, spOptions);
	$('.cep').mask('00.000-000');
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');

    // Image Logo Add
    $('.over-logo').on('click', function(){

		if ($('.file-chooser').length == 0) {
			$('.logo_area').append("<input class='file-chooser hidden' type='file' accept='image/*' name='image' >");
			$('.file-chooser').click();

			$('.file-chooser').on('change', function(e){
				$('.logo_preview').append("<img class='img-fluid logo-preview-img'>");
				$('.over-logo').html("Cancelar");
				$('.content_logo').hide();

				const fileToUpload = e.target.files[0];
			    const reader = new FileReader();
			    reader.onload = e => $('.logo-preview-img').attr('src', e.target.result);
			    reader.readAsDataURL(fileToUpload);
			});
		} else {

			html = '';
			html += '<h3>Inserir/Alterar Foto</h3>'
			$('.over-logo').html(html);

			html = '';
			html += '<div class="logo_preview"></div>'
			html += '<img class="img-fluid content_logo" src="/assets/media/default.jpg">'
			$('.area_logo').html(html);

			html = '';
			$('.logo_area').html(html);
		}
	});

	// Alinhamento do heigth do hover da inclusão de foto da empresa
	$('.edit_logo').on('mouseenter', function(){
		let height = $('.area_logo').height();
		let width = $('.area_logo').width();
		
		$('.over-logo').height(height);
		$('.over-logo').width(width);
	});
});