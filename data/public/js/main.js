function validateEmail(email) {
    let res = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return res.test(email);
}

(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        });

    var sortByValue = new URLSearchParams(window.location.search).get('sortBy');
    var sortOrderValue = new URLSearchParams(window.location.search).get('sortOrder');
    var sortSelect = document.getElementById('sortBy');
    var sortOrderSelect = document.getElementById('sortOrder');
    if (sortByValue) {
        sortSelect.value = sortByValue;
    }
    if (sortOrderValue) {
        sortOrderSelect.value = sortOrderValue;
    }

    sortSelect.addEventListener('change', function (event) {
        var params = urlParams.get();
        if (this.value === 'Выбрать') {
            params.delete('sortBy');
            params.delete('sortOrder');
        } else {
            params.set('sortBy', this.value);
            params.set('sortOrder', sortOrderSelect.value);
        }
        urlParams.update(params);
    });
    sortOrderSelect.addEventListener('change', function (event) {
        var params = urlParams.get();
        if (sortSelect.value === 'Выбрать') {
            params.delete('sortBy');
            params.delete('sortOrder');
        } else {
            params.set('sortBy', sortSelect.value);
            params.set('sortOrder', this.value);
        }
        urlParams.update(params);
    });
})()