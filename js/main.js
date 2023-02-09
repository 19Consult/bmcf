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

	$('input[type="tel"]').inputmask({"mask": "+43 699 999999"});

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

});
