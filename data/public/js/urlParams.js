var urlParams = {
    get: function get() {
        return new URLSearchParams(window.location.search);
    },

    update: function update(params) {
        window.location.search = params.toString();
    },
}
