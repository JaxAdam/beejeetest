<ul class="nav justify-content-center mt-3">
    <li class="nav-item m-2">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Сортировать по
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item <?php echo ($sortBy != 'user') ?: 'disabled'; ?>" href="/changesortby/user">Имени
                    пользователя</a>
                <a class="dropdown-item <?php echo ($sortBy != 'email') ?: 'disabled'; ?>" href="/changesortby/email">Email</a>
            </div>
        </div>
    </li>
    <li class="nav-item m-2">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Порядок сортировки
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item <?php echo ($sortDirection != 'ASC') ?: 'disabled'; ?>"
                   href="/changesortdirection/asc">По возрастанию</a>
                <a class="dropdown-item <?php echo ($sortDirection != 'DESC') ?: 'disabled'; ?>"
                   href="/changesortdirection/desc">По убыванию</a>
            </div>
        </div>
    </li>
    <li class="nav-item m-2">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">Статус
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item <?php if ($tasksStatus === 1) echo 'disabled'; ?>" href="/changetaskstatus/1">Выполнено</a>
                <a class="dropdown-item <?php if ($tasksStatus === 0) echo 'disabled'; ?>" href="/changetaskstatus/0">Не
                    выполнено</a>
                <a class="dropdown-item <?php if ($tasksStatus === null) echo 'disabled'; ?>"
                   href="/changetaskstatus/2">Все</a>
            </div>
        </div>
    </li>
    <li class="nav-item m-2">
        <a class="btn btn-primary text-white" href="/reloadpage">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-repeat" fill="currentColor"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M2.854 7.146a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L2.5 8.207l1.646 1.647a.5.5 0 0 0 .708-.708l-2-2zm13-1a.5.5 0 0 0-.708 0L13.5 7.793l-1.646-1.647a.5.5 0 0 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0 0-.708z"/>
                <path fill-rule="evenodd"
                      d="M8 3a4.995 4.995 0 0 0-4.192 2.273.5.5 0 0 1-.837-.546A6 6 0 0 1 14 8a.5.5 0 0 1-1.001 0 5 5 0 0 0-5-5zM2.5 7.5A.5.5 0 0 1 3 8a5 5 0 0 0 9.192 2.727.5.5 0 1 1 .837.546A6 6 0 0 1 2 8a.5.5 0 0 1 .501-.5z"/>
            </svg>
        </a>
    </li>
</ul>
<?php if ($shownTasksCount > 0): ?>
    <div class="row mt-4">
        <div class="col-md-6 col-sm-12 text-center">
            <p class="mt-2">Показано задач: <?php echo $shownTasksCount; ?> из <?php echo $totalTasksCount; ?></p>
        </div>
        <div class="col-md-6 col-sm-12 text-center">
            <?php if ($pagination !== null) echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($shownTasksCount == 0): ?>
    <div class="alert alert-primary mt-5" role="alert">
        <p>Задач не найдено. Попробуйте задать другие параметры или добавьте новую задачу.</p>
        <a href="/1" class="btn btn-primary ml-2 mb-2">На
            первую страницу</a>
        <a href="/deleteparams" class="btn btn-primary ml-2 mb-2">Сбросить все</a>
        <a href="/add" class="btn btn-primary ml-2 mb-2">Добавить новую задачу</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php foreach ($tasks as $task) : ?>
    <div class="card w-100 mt-4">
        <div class="card-body">
            <h5 class="card-title text-primary"><?php echo $task['user'] ?> (<?php echo $task['email'] ?>)</h5>
            <p class="card-text"><?php echo $task['text'] ?></p>
            <p>
                <?php if ($task['status'] == 0): ?>
                    <span class="badge badge-secondary">Не выполнено</span>
                <?php elseif ($task['status'] == 1): ?>
                    <span class="badge badge-success">Выполнено</span>
                <?php endif; ?>
                <?php if ($task['edited'] == 1): ?>
                    <span class="badge badge-primary">Отредактировано администратором</span>
                <?php endif; ?>
            </p>
            <div class="row float-right">
                <?php if ($admin === true): ?>
                    <a href="/switchstatus/<?php echo $task['id'] ?>" class="btn btn-info mr-2">Сменить статус</a>
                    <a href="/edit/<?php echo $task['id'] ?>" class="btn btn-warning  mr-2">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                            <path fill-rule="evenodd"
                                  d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                        </svg>
                    </a>
                    <a href="/delete/<?php echo $task['id'] ?>" class="btn btn-danger  mr-3">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
<?php endforeach; ?>
<?php if ($shownTasksCount > 0): ?>
    <div class="row mt-4">
        <div class="col-md-6 col-sm-12 text-center">
            <p class="mt-2">Показано задач: <?php echo $shownTasksCount; ?> из <?php echo $totalTasksCount; ?></p>
        </div>
        <div class="col-md-6 col-sm-12 text-center">
            <?php if ($pagination !== null) echo $pagination; ?>
        </div>
    </div>
<?php endif; ?>
