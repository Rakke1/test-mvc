var todoApp = {
    new: function()
    {
        var modal = new bootstrap.Modal(document.getElementById('todoModal'));
        modal.show();
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

    edit: async function (todoId) {
        var todo = await this.getTodo(todoId);
        var form = document.getElementById('editTodoForm');
        form['username'].setAttribute('value', todo.username);
        form['email'].setAttribute('value', todo.email);
        form['todo'].value = todo.todo;
        form.setAttribute('data-id', todo.ID);
        var modal = new bootstrap.Modal(document.getElementById('todoEditModal'));
        modal.show();
    },

    update: async function update() {
        var form = document.getElementById('editTodoForm');
        const todoId = form.getAttribute('data-id');

        if (!form.checkValidity()) {
            return;
        }

        var formData = new FormData();
        formData.append('todo', form['todo'].value);

        let response = await fetch('/updateTodo?id=' + todoId, {
            method: 'POST',
            body: formData,
        });
        let result = await response.json();
        let code = await response.status;

        if (result.status) {
            alert('Задача обновлена');
        } else if (code === 403) {
            alert('Необходимо авторизоваться');
            window.location.replace('/login');
        } else {
            alert('Произошла ошибка');
        }
    },

    setDone: async function setDone(todoId)
    {
        let response = await fetch('/todoDone?id=' + todoId, {
            method: 'POST',
        });
        let result = await response.json();

        if (result.status) {
            alert('Задача выполнена');
        } else {
            alert('Произошла ошибка');
        }
    },

    getTodo: async function getTodo(todoId)
    {
        let response = await fetch('/todo?id=' + todoId, {
            method: 'GET',
        });
        let result = await response.json();
        if (result) {
            return result;
        } else {
            alert('Произошла ошибка');
        }
    }
}