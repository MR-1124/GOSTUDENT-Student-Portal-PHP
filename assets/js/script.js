document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    M.FormSelect.init(elems);
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);
});