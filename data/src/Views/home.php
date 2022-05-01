<?php

/** @var array $todoList */
/** @var int $todoNum */
/** @var int $limit */
/** @var int $pageNum */
/** @var int $totalPageNum */
/** @var bool $isAuth */
/** @var bool $isAdmin */

use Rakke1\TestMvc\Models\TodoList;
use Rakke1\TestMvc\Helpers\HtmlHelper;

?>

<div class="container">
    <div class="row mb-1 mt-1 position-relative">
        <div class="col-12 mb-1 mt-1">
            <div class="btn-group float-end" role="group">
                <button type="button" class="btn btn-primary" onclick="todoApp.new()">Добавить задачу</button>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($todoList as $todo): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo HtmlHelper::encode($todo['username']) .
                                '(' . HtmlHelper::encode($todo['email']) . ')'?>
                        </h5>
                        <p class="card-text">
                            <?php echo HtmlHelper::encode($todo['todo']) ?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <?php if ($isAdmin): ?>
                            <div class="btn-toolbar">
                                <div class="btn-group" role="group">
                                    <button
                                        class="btn btn-outline-primary me-2"
                                        onclick="todoApp.edit(<?php echo $todo['ID'] ?>)"
                                    >
                                        Редактировать
                                    </button>
                                    <?php if ((int)$todo['status'] !== TodoList::$STATUS_DONE): ?>
                                        <button
                                            class="btn btn-outline-success me-2"
                                            onclick="todoApp.setDone(<?php echo $todo['ID'] ?>)"
                                        >
                                            Выполнено
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row mt-1" role="group">
                            <?php if ((int)$todo['status'] === TodoList::$STATUS_DONE): ?>
                                <div class="col-2">
                                    <span class="badge bg-success">выполнено</span>
                                </div>
                            <?php endif; ?>

                            <?php if ($todo['was_edit_admin']): ?>
                                <div class="col-7">
                                    <span class="badge bg-primary">отредактировано администратором</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($todoNum > $limit): ?>
    <div class="row mb-1 mt-2">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php echo $pageNum <= 1 ? 'Disabled' : '' ?>">
                    <a class="page-link" href="#" onclick="pagination.previousPage()">Предыдущая</a>
                </li>
                <?php for (
                        $pageCounter = ($pageNum <= 1 ? $pageNum : $pageNum - 1);
                        $pageCounter <= $pageNum + 1;
                        $pageCounter++
                ): ?>
                    <?php if ($totalPageNum < $pageCounter) { break; } ?>

                    <li class="page-item <?php echo $pageCounter === $pageNum ? 'Active' : '' ?>">
                        <a class="page-link" onclick="pagination.toPage(<?php echo $pageCounter ?>)" href="#">
                            <?php echo $pageCounter ?>
                        </a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo $totalPageNum <= $pageNum ? 'Disabled' : '' ?>">
                    <a class="page-link" onclick="pagination.nextPage()" href="#">Следующая</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<div class="modal fade" tabindex="-1" id="todoModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Новая задача</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="newTodoForm" method="post" action="/todo">
                    <label class="form-label" for="username">Имя</label>
                    <input class="form-control" type="text" name="username" id="username" required/>
                    <label class="form-label" for="email">E-mail</label>
                    <input class="form-control" type="email" id="email" name="email" required/>
                    <label class="form-label" for="todo">Текст</label>
                    <textarea class="form-control" rows="4" name="todo" id="todo" required></textarea>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="todoApp.save()">Сохранить</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="todoEditModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Редактирование задачи</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="editTodoForm" class="needs-validation was-validated" method="post" action="/todo" novalidate>
                    <label class="form-label" for="username">Имя</label>
                    <input class="form-control" disabled type="text" name="username" id="username" required/>
                    <label class="form-label" for="email">E-mail</label>
                    <input class="form-control" disabled type="email" id="email" name="email" required/>

                    <label class="form-label" for="todo">Текст</label>
                    <textarea class="form-control" rows="4" name="todo" id="todo" required></textarea>
                    <div class="invalid-feedback">
                        Пожалуйста укажите Текст
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="todoApp.update()">Сохранить</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<?php
