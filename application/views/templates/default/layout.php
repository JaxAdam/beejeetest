<?php
header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/requirement.png" type="image/x-icon">
    <title>Задачи</title>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
</head>
<body>
<h1 class="text-center font-weight-bold mt-5 mb-5 text-primary">Задачник онлайн</h1>
<ul class="nav justify-content-center nav-pills mt-3">
    <li class="nav-item">
        <a class="nav-link" href="/">Список задач</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/add">Добавить задачу</a>
    </li>
    <?php if(empty($userEmail) && empty($userName)) :?>
    <li class="nav-item">
        <a class="nav-link" href="/login">Войти</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/signup">Регистрация</a>
    </li>
    <?php else:?>
    <li class="nav-item">
        <a class="nav-link" href="/logout">Выйти (<?php echo $userName?>)</a>
    </li>
    <?php endif;?>
</ul>
<main role="main" class="container mt-3">
    <?php echo $content; ?>
</main>
<div class="toasts"></div>
<div class="modal fade" id="dangerActionModal" tabindex="-1" aria-labelledby="dangerActionModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Подтверждение действия</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Вы собираетесь сделать необратимое действие, вы в этом уверены?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                <a href="/" class="btn btn-primary" id="yesLink">Да</a>
            </div>
        </div>
    </div>
</div>


<script src="/js/jquery.js" crossorigin="anonymous"></script>
<script src="/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="/js/script.js" crossorigin="anonymous"></script>
</body>
</html>

