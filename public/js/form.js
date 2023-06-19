let form = document.querySelector('form');
let unsavedChanges = false;

form.addEventListener('input', function() {
    unsavedChanges = true;
});

window.addEventListener('beforeunload', function(e) {
    if (unsavedChanges) {
        e.preventDefault();
        e.returnValue = 'You have not saved your data. Are you sure you want to reload the page?';
        return 'You have not saved your data. Are you sure you want to reload the page?';
    }
});

// function saveBtn(){
//     unsavedChanges = false;
//     let form = document.querySelector('form');
//     form.submit();
// }

function saveBtn() {
    unsavedChanges = false;
    let forms = document.querySelectorAll('form');
    let lastForm = forms[forms.length - 1];

    if ( validateEmail() ){
        lastForm.submit();
    }else {
        return;
    }

    //lastForm.submit();
}


let btn_send = document.querySelector(".send.send-form");
btn_send.addEventListener('click', function() {
    unsavedChanges = false;
});


document.addEventListener('DOMContentLoaded', function () {
    $(document).ready(function () {
        $('.select-list').select2();
    });
})


function validateEmail() {
    var emailInput = document.getElementById('mail');

    if (emailInput) {
        var email = emailInput.value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailRegex.test(email)) {
            return true;
        } else {
            alert('Email entered incorrectly.');
            return false;
        }
    } else {
        return true;
    }
}
