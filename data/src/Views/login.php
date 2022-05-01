<?php
?>

<main class="form-signin">
    <form class="needs-validation" id="loginForm" method="post" action="/login" novalidate>
        <h1 class="h3 mb-3 fw-normal">Логин</h1>

        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="username" placeholder="test" required>
            <label for="username">Имя</label>
            <div class="invalid-feedback">
                Пожалуйста укажите Имя
            </div>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
            <label for="password">Пароль</label>
            <div class="invalid-feedback">
                Пожалуйста укажите Пароль
            </div>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
    </form>
</main>

<script src="/js/login.js"></script>

<?php
