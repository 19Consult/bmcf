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

	$(document).mouseup(function (e) {
		let div = $(".popup__content");
		if (!div.is(e.target)
			&& div.has(e.target).length === 0) {
			$('.popup').removeClass('open');
		};
	});

	$('.scrollbar-init').scrollbar();

	$('input[type=file]').on('change', function () {
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

});

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