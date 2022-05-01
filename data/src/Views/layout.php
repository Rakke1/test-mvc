<?php
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/signin.css" rel="stylesheet">

<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">TodoList</a>
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link <?php echo $currentPath === '/' ? 'active' : ''; ?>" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $currentPath === '/login' ? 'active' : ''; ?>" href="/login">Login</a>
            </li>
        </ul>
    </div>
</nav>

<?php
