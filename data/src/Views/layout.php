<?php
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<link href="/css/bootstrap.min.css" rel="stylesheet" xmlns="http://www.w3.org/1999/html">
<link href="/css/signin.css" rel="stylesheet">

<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">TodoList</a>
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?> p-2" aria-current="page" href="/">Задачи</a>
            </li>
            <?php if (isset($userId)): ?>
                <li class="nav-item">
                    <form method="post" class="p-0 m-0" action="/logout">
                        <button class="btn btn-outline-light border-0 p-2" type="submit">Выйти</button>
                    </form>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $currentPath === '/login' ? 'active' : ''; ?> p-2" href="/login">Войти</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php
