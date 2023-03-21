// import * as CKEDITOR from 'ckeditor/ckeditor/ckeditor.js';
// export default CKEDITOR;
// import ClassicEditor from 'ckeditor4';
// const editor = CKEDITOR.create( document.querySelector( '#editor' ) );
//
//
// CKEDITOR.replace('editor');

jQuery(document).ready(function ($) {
	$('body').on('click', '.show-password', function () {
		if ($(this).is(':checked')) {
			$(this).siblings('input').attr('type', 'text');
		} else {
			$(this).siblings('input').attr('type', 'password');
		}
	});
	$('select').select2({
		minimumResultsForSearch: Infinity,
		dropdownCssClass: 'select-dropdown',
	})
	

	// $('input[type="tel"]').inputmask({ "mask": "+43 699 999999" });

	const fileUploader = document.getElementById('file-uploader');
	const reader = new FileReader();
	const imageWrap = document.getElementById('show-photo-wrapper');
	const imageGrid = document.getElementById('show-photo');

	if (fileUploader) {
		fileUploader.addEventListener('change', (event) => {
			imageWrap.classList.add('show')
			const files = event.target.files;
			const file = files[0];
			reader.readAsDataURL(file);

			reader.addEventListener('load', (event) => {
				const img = document.createElement('img');
				imageGrid.querySelector('img').remove();
				imageGrid.appendChild(img);
				img.src = event.target.result;
				img.alt = file.name;
			});
		});
	}

	if ($('.project__nda-user-wrap')) {
		if ($('.project__nda-user-wrap .project__nda-user').length > 5) {
			$('.project__nda-user-wrap').addClass('many');
			const quantity = $('.project__nda-user-wrap .project__nda-user').length
			$('.project__nda-quantity').text(`+${quantity - 4}`);
		}
	}

	$('.projects-search-v1 .project__title').click(function(){
		$('.project-preview').addClass('open');
	})
	$('.projects-search-v2 .project__title').click(function(){
		$('.projects-wrapper').fadeOut(function(){
			$('.project-preview__wrap--page').addClass('open');
		});
	})
	$('.projects-search-v2 .nav__back a').click(function(){
		$('.projects-wrapper').delay(400).fadeIn(100);
		$('.project-preview__wrap--page').removeClass('open');
	})

	$('.nda__content .nda__item--title').click(function(){
		$('.nda-wrap').fadeOut(function(){
			$('.nda-more-wrap').addClass('open');
		});
	})
	$('.nda-more-wrap .nav__back a').click(function(){
		$('.nda-wrap').delay(400).fadeIn(100);
		$('.nda-more-wrap').removeClass('open');
	})

	$('.profile .btn.send').click(function (e) {
		// e.preventDefault();
		$('.create-project--popup').addClass('open');
	});

	// Create project open popup for description
	$('.project-create__top-descr .field-add, .project-create__top-descr .field-text__edit').click(function (e) {
		// e.preventDefault();
		$('.project-create__top--popup').addClass('open');
	});

	// Create project open popup for field
	$('.project-create .field-add, .project-create .field-text__edit').click(function(e){
		// $('.popup').addClass('open');
		$(this).parents('.form_input_wrap').siblings('.popup').addClass('open')
		$('html').css('overflow','hidden')
	})
	
	// hide popup
	$('.popup .popup__nav a').click(function(e){
		e.preventDefault()
		$('.popup').removeClass('open');
		$('html').css('overflow','')
	})

	// $(document).mouseup(function (e) {
	// 	// console.log($('body').children('.select2-container').length === 0)
	// 	let div = $(".popup__content");
	// 	let cke = $('body').children('.cke_dialog_container');
	// 	// let select2 = $('body').children('.select2-container').length === 0;
	// 	let select = $('body > .select2-container').length === 0;
	// 	let select2 = $('body').children('.select2-container');
	// 	console.log(!cke.is(e.target))
	// 	console.log('select: ' +select)
	// 	console.log('select: ' +!select2.is(e.target))
	// 	console.log(select2.has(e.target).length !== 1)
	// 	console.log(cke.has(e.target).length === 0)
	// 	console.log(div.has(e.target).length === 0)
	// 	// let result = $('body .select2-container .select2-results__option');
	// 	if (!div.is(e.target)
	// 		&& !cke.is(e.target)
	// 		&& !select2.is(e.target)
	// 		// && !result.is(e.target)
	// 		&& cke.has(e.target).length === 0
	// 		// && select2.has(e.target).length === 0
	// 		// && result.has(e.target).length === 0
	// 		&& div.has(e.target).length === 0
	// 		&& select2.has(e.target).length === 0
	// 		&& select
	// 		) {
	// 		$('.popup').removeClass('open');
	// 		$('html').css('overflow','')
	// 	};
	// });

	$('.scrollbar-inner').scrollbar();


	$('input[type=file][name="file"]').on('change', function () {
		let $files_list = $(this).parents('.add-file-field').siblings('.add-file-input-text');
		$files_list.empty();

		for (let i = 0; i < this.files.length; i++) {
			let new_file_input = '<div class="add-file-input-item">' +
				'<span class="add-file-input-name">' + this.files.item(i).name + '</span>' +
				'<a href="#" onclick="removeFilesItem(this); return false;" class="add-file-remove">x</a>' +
				'</div>';
			$files_list.append(new_file_input);
			dt.items.add(this.files.item(i));
		};
		this.files = dt.files;
	});

	$('.nda-info__read-more').click(function () {
		$(this).toggleClass('active');
		$('.nda-info__content').toggleClass('show');
	})

	$('#signature').on('mousedown', function () {
		$(this).parents('.nda-info__signature').addClass('active');
	})

	$('.remove-signature').click(function () {
		$(this).parents('.nda-info__signature').removeClass('active');
		signatureClear();
	})

	if( $('.nda-agreement--popup').hasClass('open')) {
		$('html').css('overflow', 'hidden');
	} else {
		$('html').css('overflow', '');
	}
	$('.nda-info__btn-confirm').click(function () {
		$('.nda-agreement--popup').removeClass('open');
	})


    $(".click-select-country").change(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if($(this).val() == 0) return false;

        let value = $(this).val();

        $.ajax({
            url: "/ajax-get-cities",
            method: 'post',
            data: {
                code_country: value,
            },
            success: function(result){
                $('.click-select-cities').find('option').remove();
                result.cities.forEach(function callback(currentValue) {
                    $('.click-select-cities').append( $('<option value="' + currentValue + '">' + currentValue + ' </option>'));
                });
            }});
    });

	$('.alert-box button.close').click(function(){
		$(this).parents('.alert-box').remove()
	})

	if( $('.alert-box').length > 0 ) {
		setTimeout(() => {
			$('.alert-box').remove()
		}, 7000);
	}


});

$(function () {
	var input = document.querySelectorAll("input[type=tel]");
	var iti_el = $('.iti.iti--allow-dropdown.iti--separate-dial-code');
	if(iti_el.length){
		iti.destroy();
	}

	for(var i = 0; i < input.length; i++){
		iti = intlTelInput(input[i], {
			autoHideDialCode: false,
			autoPlaceholder: "aggressive" ,
			initialCountry: "auto",
			separateDialCode: true,
			preferredCountries: ['ua'],
			customPlaceholder:function(selectedCountryPlaceholder,selectedCountryData){
				return ''+selectedCountryPlaceholder.replace(/[0-9]/g,'X');
			},
			geoIpLookup: function(callback) {
				$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
					var countryCode = (resp && resp.country) ? resp.country : "";
					callback(countryCode);
				});
			},
			utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"
	});

	$('input[type=tel]').on("focus click countrychange", function(e, countryData) {

		var pl = $(this).attr('placeholder') + '';
		var res = pl.replace( /X/g ,'9');
		if(res != 'undefined'){
			$(this).inputmask(res, {placeholder: "X", clearMaskOnLostFocus: true});
		}
	});
	$('input[type=tel]').on("focusout", function(e, countryData) {
		var intlNumber = iti.getNumber();
		console.log(intlNumber);
	});
}


})

var dt = new DataTransfer();

function removeFilesItem(target){
	let name = $(target).prev().text();
	let input = $(target).closest('.input-file-row').find('input[type=file]');
	$(target).closest('.add-file-input-item').remove();
	for(let i = 0; i < dt.items.length; i++) {
		if(name === dt.items[i].getAsFile().name) {
			dt.items.remove(i);
		}
	}
	input[0].files = dt.files;
}

// signature
function signatureClear() {
	let canvas = document.getElementById("signature");
	let context = canvas.getContext("2d");

	context.clearRect(0, 0, canvas.width, canvas.height);
}

if( $('.nda-info__signature').length > 0) {
	let canvas = document.getElementById("signature"),
		context = canvas.getContext("2d"),
		mouse = { x:0, y:0 },
		draw = false
	;

	context.strokeStyle = "black";

	canvas.addEventListener("mousedown", function(e){

		let ClientRect = this.getBoundingClientRect();
		mouse.x = e.clientX - ClientRect.left;
		mouse.y = e.clientY - ClientRect.top;

		draw = true;
		context.beginPath();
		context.moveTo(mouse.x, mouse.y);
	});
	canvas.addEventListener("mousemove", function(e){

		if(draw === true){
			let ClientRect = this.getBoundingClientRect();

			mouse.x = e.clientX - ClientRect.left;
			mouse.y = e.clientY - ClientRect.top;

			context.lineTo(mouse.x, mouse.y);
			context.stroke();
		}
	});
	canvas.addEventListener("mouseup", function(e){

		let ClientRect = this.getBoundingClientRect();
		mouse.x = e.clientX - ClientRect.left;
		mouse.y = e.clientY - ClientRect.top;
		context.lineTo(mouse.x, mouse.y);
		context.stroke();
		context.closePath();
		draw = false;
	});
}
