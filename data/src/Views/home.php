<?php

/** @var array $todoList */
/** @var int $todoNum */
/** @var int $limit */
/** @var int $pageNum */
/** @var int $totalPageNum */

use Rakke1\TestMvc\Models\TodoList;

?>

<div class="container">
    <div class="row mb-1 mt-1 position-relative">
        <div class="col-12 mb-1 mt-1">
            <div class="btn-group float-end" role="group">
                <button type="button" class="btn btn-primary" onclick="newTodo()">Добавить задачу</button>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($todoList as $todo): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($todo['username'],  ENT_QUOTES, 'UTF-8') .
                                '(' . htmlspecialchars($todo['email'],  ENT_QUOTES, 'UTF-8') . ')'?>
                        </h5>
                        <p class="card-text"><?php echo htmlspecialchars($todo['todo'],  ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div class="card-footer">
                        <?php if ($todo['status'] === TodoList::$STATUS_DONE): ?>
                            <span class="badge bg-success">выполнено</span>
                        <?php endif; ?>
                        <?php if ($todo['was_edit_admin']): ?>
                            <span class="badge bg-primary">отредактировано администратором</span>
                        <?php endif; ?>
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
                <?php for ($pageCounter = $pageNum; $pageCounter <= $pageNum + 2; $pageCounter++): ?>
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
                <button type="button" class="btn btn-success" onclick="saveTodo()">Сохранить</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<?php
