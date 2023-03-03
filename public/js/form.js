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

function saveBtn(){
    unsavedChanges = false;
    let form = document.querySelector('form');
    form.submit();
}
