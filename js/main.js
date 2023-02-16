/* eslint-disable indent */
/* eslint-disable func-names */
/* eslint-disable no-tabs */
/* eslint-disable linebreak-style */
/* eslint-disable no-unused-vars */
/* eslint-disable prefer-arrow-callback */
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
		// dropdownParent: $('#myModal'),
		dropdownCssClass: 'select-dropdown',
	})

	const fileUploader = document.getElementById('file-uploader');
	const reader = new FileReader();
	const imageWrap = document.getElementById('show-photo-wrapper');
	const imageGrid = document.getElementById('show-photo');

	$('input[type="tel"]').inputmask({ "mask": "+43 699 999999" });

	if (fileUploader) {
		fileUploader.addEventListener('change', (event) => {
			imageWrap.classList.add('show')
			const files = event.target.files;
			const file = files[0];
			reader.readAsDataURL(file);

			reader.addEventListener('load', (event) => {
				const img = document.createElement('img');
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
			$('.project-preview__wrap--page').fadeIn(100);
		});
	})
	$('.projects-search-v2 .nav__back a').click(function(){
		$('.project-preview__wrap--page').fadeOut(function(){
			$('.projects-wrapper').fadeIn(100);
		});
	})

	$('.profile .btn.send').click(function (e) { 
		// e.preventDefault();
		$('.create-project--popup').addClass('open');
	});

	$('.project-create__top-descr .field-add').click(function (e) { 
		// e.preventDefault();
		$('.project-create__top--popup').addClass('open');
	});

	// project create story
	$('.project-field .field-add').click(function (e) { 
		// e.preventDefault();
		$('.project-field .popup').addClass('open');
	});

	// Business Plan
	$('.project-plan .field-add').click(function (e) { 
		// e.preventDefault();
		$('.project-plan .popup').addClass('open');
	});

	// CoFounder Terms & Conditions
	$('.project-co-founder .field-add').click(function (e) { 
		// e.preventDefault();
		$('.row.project-co-founder .popup').addClass('open');
	});

	// CoFounder Terms & Conditions - fill
	$('.project-story .send').click(function (e) { 
		// e.preventDefault();
		$('.popup.fill').addClass('open');
	});

	// hide popup
	$('.popup .popup__nav a').click(function(e){
		e.preventDefault()
		$('.popup').removeClass('open');
	})

	$(document).mouseup(function (e) { // событие клика по веб-документу
		let div = $(".popup__content"); // тут указываем ID элемента
		if (!div.is(e.target) // если клик был не по нашему блоку
			&& div.has(e.target).length === 0) { // и не по его дочерним элементам
			$('.popup').removeClass('open');
		};
	});

});
