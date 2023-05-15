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

    function bytesToKilobytes(bytes) {
        return (bytes / 1024).toFixed(2);
    }


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

            //console.log( bytesToKilobytes(file.size) )

			if( bytesToKilobytes(file.size) <= 512 ){
                reader.addEventListener('load', (event) => {
                    const img = document.createElement('img');
                    imageGrid.querySelector('img').remove();
                    imageGrid.appendChild(img);
                    img.src = event.target.result;
                    img.alt = file.name;
                });

                document.querySelector(".default-img-user").classList.remove('display-none');
            }else {
			    $('.style-span-max-size').css('color', 'var(--color-warning-2)');
                console.log('max size 512 kb')
                return;
            }

		});
	}

	if ($('.project__nda-user-wrap')) {
        $('.project__nda-user-wrap').each(function(){
            if ($(this).find('.project__nda-user').length > 5) {
                $(this).addClass('many');
                const quantity = $(this).find('.project__nda-user').length
                $(this).find('.project__nda-quantity').text(`+${quantity - 4}`);
            }
        })
	}

    if ($('#city_other').is(':checked')) {
        $('#city_other_name').show();
        $('.city-checkbox').hide();
    } else {
        $('#city_other_name').hide();
        $('.city-checkbox').show();
    }

    $('#city_other').change(function() {
        if ($(this).is(':checked')) {
            $('#city_other_name').show();
            $('.city-checkbox').hide();
        } else {
            $('#city_other_name').hide();
            $('.city-checkbox').show();
        }
    });

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

	$('.popup .btn').click(function(){
		if(!$('.popup').hasClass('.open')) {
			$('html').css('overflow','')
		}
	})
	$('.scrollbar-init:not(.brief_description_project)').scrollbar()

	$('.project-create__top-descr .field-text__edit').click(function(){
		setTimeout(() => {
			$('.project-create__top-descr .scrollbar-init').scrollbar('destroy')
		}, 400);
	})
	setTimeout(() => {
		$('.brief_description_project.scrollbar-init.add-description').scrollbar()
	}, 100);

	$('.project-create__top--popup .btn-ajax-first-section').click(function(){
		setTimeout(() => {
			$('.brief_description_project.scrollbar-inner.scrollbar-init').scrollbar()
		}, 100);
	})

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
        $('.nda-agreement.nda-agreement--popup.nda-popup-list').addClass('open');
	})

    $('.nav__back .close-nda').click(function() {
        $('.nda-agreement.nda-agreement--popup').removeClass('open');
    })

    $('.nav__back a').click(function() {
        $('.nda-agreement.nda-agreement--popup').removeClass('open');
    })

    $('.project__favorite').click(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var project_id = $(this).attr('project-id');
        console.log(project_id)

        let data = {
            project_id: project_id,
        };

        $.ajax({
            url: '/project/favorite',
            method: 'POST',
            data: data,
            success: function(data) {
                let favoriteClass = $(`.favorite-projid-${project_id}`);
                let favoriteClassPopUp = $(`.favorite-pop`);
                if(data.success){
                    favoriteClass.addClass("active")
                    favoriteClassPopUp.addClass("active")
                }else {
                    favoriteClass.removeClass("active")
                    favoriteClassPopUp.removeClass("active")
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(xhr.responseText); // replace with your own error callback function
            }
        });
    });

    $('.report-problem-btn').on('click', function(event) {
        $('.report-popup').addClass('open')

        //Investor
        $('.project-id').val( $(this).attr('data-project-id') );
        $('.to-user-id').val( $(this).attr('data-owner-id') );
    });

    $('.report-form').submit(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '/report-problem',
            data: $(this).serialize(),
            success: function (response) {
                $('.report-popup').removeClass('open');
                $('.successful-popup').addClass('open');

                $('.description-report').val(" ");
                //console.log(response.message);
            }
        });
    });

    $('.share-project-btn').on('click', function(event) {
        $('.share-project-popup').addClass('open')
        $('.project-id').val( $(this).attr('data-project-id') );
    });

    $('.share-project-form').submit(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let data = $(this).serialize();
        //console.log(data);

        let emails = $('#email_list').val().split(',').filter(function(email) {
            return email.trim().length > 0;
        });

        if (emails.length > 4) {
            $('.error-label-sher').text('You can enter up to 4 email addresses');
            return;
        }

        var valid = true;
        for (var i = 0; i < emails.length; i++) {
            var email = emails[i].trim();
            if (email.length === 0) {
                continue; // пропускаем пустые значения
            }
            if (!isValidEmail(email)) {
                valid = false;
                break;
            }
        }

        if(emails.length < 1){
            $('.error-label-sher').text('You have not entered any email');
        }else if (valid) {
            $('.error-label-sher').text('');

            $.ajax({
                type: 'POST',
                url: '/share-project',
                data: $(this).serialize(),
                success: function (response) {
                    if(response.status == '1'){
                        console.log(response.message);
                        $('.share-project-popup').removeClass('open');
                        $('.share-project-successful').addClass('open');
                        $('.email_list').val(" ");
                    }

                    if(response.status == '0'){
                        console.log(response.message);
                    }
                }
            });
        } else {
            $('.error-label-sher').text('One or more email addresses are entered incorrectly');
        }

    });

    function isValidEmail(email) {
        var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return pattern.test(email);
    }

    $('.share-profile-btn').on('click', function(event) {
        $('.share-profile-popup').addClass('open')
        $('.profile-id').val( $(this).attr('data-profile-id') );
    });

    $('.share-profile-form').submit(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let data = $(this).serialize();
        //console.log(data);

        let emails = $('#email_list_pr').val().split(',').filter(function(email) {
            return email.trim().length > 0;
        });

        if (emails.length > 4) {
            $('.error-label-sher').text('You can enter up to 4 email addresses');
            return;
        }

        var valid = true;
        for (var i = 0; i < emails.length; i++) {
            var email = emails[i].trim();
            if (email.length === 0) {
                continue; // пропускаем пустые значения
            }
            if (!isValidEmail(email)) {
                valid = false;
                break;
            }
        }

        if(emails.length < 1){
            $('.error-label-sher').text('You have not entered any email');
        }else if (valid) {
            $('.error-label-sher').text('');

            $.ajax({
                type: 'POST',
                url: '/share-profile',
                data: $(this).serialize(),
                success: function (response) {
                    if(response.status == '1'){
                        console.log(response.message);
                        $('.share-profile-popup').removeClass('open');
                        $('.share-profile-successful').addClass('open');
                        $('.email_list_pr').val(" ");
                    }

                    if(response.status == '0'){
                        console.log(response.message);
                    }
                }
            });
        } else {
            $('.error-label-sher').text('One or more email addresses are entered incorrectly');
        }

    });
    //notifications
    // $('.notification-user').submit(function (e) {
    //     e.preventDefault();
    //
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //
    //     $.ajax({
    //         type: 'POST',
    //         url: '/report-problem',
    //         data: $(this).serialize(),
    //         success: function (response) {
    //             $('.report-popup').removeClass('open');
    //             $('.successful-popup').addClass('open');
    //
    //             $('.description-report').val(" ");
    //             //console.log(response.message);
    //         }
    //     });
    // });

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

	// new click country
    //click-div-country
    $(".click-div-country").click(function(e){
        //e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let value = $(this).attr("data-value");

        $.ajax({
            url: "/ajax-get-cities",
            method: 'post',
            data: {
                code_country: value,
            },
            success: function(result){

                $('.city-select-class').val('');
                $('.ples-city-change .text').text('Select city');

                $('.list-cities-div').find('div').remove();
                result.cities.forEach(function callback(currentValue) {
                    $('.list-cities-div').append( $('<div class="item" data-value="' + currentValue + '">' + currentValue + ' </div>'));
                });
        }});
    });
	// --new click country

	$('.alert-box button.close').click(function(){
		$(this).parents('.alert-box').remove()
	})

	if( $('.alert-box').length > 0 ) {
		setTimeout(() => {
			$('.alert-box').remove()
		}, 7000);
	}

	$('body').on('click','.nav__notifications.has-notific', function(){
		$(this).siblings('.nav__notifications-popup').toggleClass('show')

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if($('.nav__notifications-popup').hasClass('show')){

            //let notificationId = $(this).attr('data-id');
            let notificationId = "all";
            //console.log(notificationId);

            $.ajax({
                url: `/notifications/${notificationId}/mark-as-read`,
                type: 'POST',
                data: [],
                success: function(data) {
                    console.log(data);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                }
            });

        }

	})

	$('.nda__more').click(function(){
		if(!$(this).hasClass('open')) {
			$('.nda__more').removeClass('open');
			$(this).addClass('open');
		} else {
			$(this).removeClass('open');
		}
	})
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

    // let tel_start = $('input[type=tel]');
    // console.log(tel_start)
    // if(tel_start.val() == ''){
    //     tel_start.val('+380');
    // }

        let code_tel = $('.iti__selected-dial-code').text();
        $('.class-code-phone').val(code_tel)

	$('input[type=tel]').on("focus click countrychange", function(e, countryData) {

	    let code_tel = $('.iti__selected-dial-code').text();
	    $('.class-code-phone').val(code_tel)

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

if( $('.nda-info__signature').length > 0 && false) {
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


// $('.notification-user').click(function (event) {
//
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//
//     let notificationId = $(this).attr('data-id');
//     //console.log(notificationId);
//
//     $.ajax({
//         url: `/notifications/${notificationId}/mark-as-read`,
//         type: 'POST',
//         data: [],
//         success: function(data) {
//             console.log(data);
//         },
//         error: function(xhr, textStatus, errorThrown) {
//             console.log(xhr.responseText);
//         }
//     });
//
// })

$(document).ready(function() {
    $('.ui.dropdown').dropdown({
        fullTextSearch: true
    });
});
