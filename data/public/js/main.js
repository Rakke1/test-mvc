function newTodo() {
    var modal = new bootstrap.Modal(document.getElementById('todoModal'))
    modal.show();
}

async function saveTodo() {
    let newForm = document.getElementById('newTodoForm');
    let formData = new FormData(newForm);
    let username = formData.get('username');
    let email = formData.get('email');
    let todo = formData.get('todo');

    if (username.trim() === '') {
        alert('Поле Имя не заполнено');
        return;
    }
    if (email.trim() === '') {
        alert('Поле E-mail не заполнено');
        return;
    }
    if (validateEmail(email.trim()) !== true) {
        alert('Поле E-mail не валидно');
        return;
    }
    if (todo.trim() === '') {
        alert('Поле Текст не заполнено');
        return;
    }

    let response = await fetch('/todo', {
        method: 'POST',
        body: formData
    });
    let result = await response.json();

    if (result.status) {
        alert('Задача создана');
    } else {
        alert('Произошла ошибка');
    }
}

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
})()