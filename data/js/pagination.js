var pagination = {
    previousPage: function previousPage() {
        let page = this.getPage();
        this.toPage(page - 1);
    },

    nextPage: function nextPage() {
        let page = this.getPage();
        this.toPage(page + 1);
    },

    toPage: function toPage(page) {
        const params = this.getParams();
        params.set('page', page);
        this.updateParams(params);
    },

    getParams: function getParams() {
        return new URLSearchParams(window.location.search);
    },

    updateParams: function updateParams(params) {
        window.location.search = params.toString();
    },

    getPage: function getPage() {
        const params = this.getParams();
        const page = parseInt(params.get("page"));

        if (!page) {
            return 1;
        }

        return page;
    },
}
