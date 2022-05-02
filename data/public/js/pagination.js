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
        const params = urlParams.get();
        params.set('page', page);
        urlParams.update(params);
    },

    getPage: function getPage() {
        const params = urlParams.get();
        const page = parseInt(params.get("page"));

        if (!page) {
            return 1;
        }

        return page;
    },
}
