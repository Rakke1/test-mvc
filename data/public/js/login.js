(function () {
    'use strict'

    var loginForm = document.getElementById('loginForm');
    loginForm.addEventListener("submit", async function (e) {
        event.preventDefault();

        if (loginForm.checkValidity()) {
            let formData = new FormData(loginForm);
            let response = await fetch('/login', {
                method: 'POST',
                body: formData
            });
            let result = await response.json();

            if (result.status == false) {
                alert(result.message);
                return;
            }
        }
    }, true);
})()