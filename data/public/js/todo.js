var todoApp = {
    new: function()
    {
        var modal = new bootstrap.Modal(document.getElementById('todoModal'))
        modal.show();
    },

    edit: function (todoId) {

    },

    save: async function() {
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
    },

    setDone: async function setDone(todoId)
    {
        let response = await fetch('/todoDone?id=' + todoId, {
            method: 'POST',
            data: {
                'status': 1
            }
        });
        let result = await response.json();

        if (result.status) {
            alert('Задача выполнена');
        } else {
            alert('Произошла ошибка');
        }
    },

}