(function () {
    'use strict'
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