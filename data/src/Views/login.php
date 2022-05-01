<?php
?>

<main class="form-signin">
    <form class="needs-validation" method="post" action="/sign-in" novalidate>
        <h1 class="h3 mb-3 fw-normal">Логин</h1>

        <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="test" required>
            <label for="floatingInput">Имя</label>
            <div class="invalid-feedback">
                Пожалуйста укажите Имя
            </div>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="password" required>
            <label for="floatingPassword">Пароль</label>
            <div class="invalid-feedback">
                Пожалуйста укажите Пароль
            </div>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
    </form>
</main>

<?php
