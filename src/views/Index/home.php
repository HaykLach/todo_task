<?php require_once APPROOT . '/src/views/include/header.php'; ?>
    <section class="vh-100" style="background-color: #eee;" xmlns="http://www.w3.org/1999/html">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card rounded-3">
                        <div class="card-body p-4">

                            <h4 class="text-center my-3 pb-3">To Do App</h4>
                            <form id="create_task" action="/save_task" method="post" autocomplete="on"
                                  class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                                <ul class="error_list">

                                </ul>
                                <div class="form-row">
                                    <div class="col-3">
                                        <input type="text" id="email" name="email" class="form-control required_form"
                                               placeholder="Email">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" id="username" name="username"
                                               class="form-control required_form" placeholder="Username">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" id="description" name="description"
                                               class="form-control required_form" placeholder="Task">
                                    </div>
                                    <div class="col">
                                        <button type="submit" id="save_task" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                            <form action="" method="get">
                                <span>Order by:</span>
                                <input type="radio" name="sort_by" class="sort_by" value="username"> User
                                <input type="radio" name="sort_by" class="sort_by" value="email"> Email
                                <input type="radio" name="sort_by" class="sort_by" value="completed"> Status
                                <p></p>
                                <span>Sort by:</span>
                                <input type="radio" name="order_by" class="order_by" value="asc"> Ascending
                                <input type="radio" name="order_by" class="order_by" value="desc"> Descending
                                <p></p>
                                <div class="col">
                                    <button type="submit" id="apply_filter" class="btn btn-primary">Apply Filter
                                    </button>
                                </div>
                            </form>
                            <table class="table mb-4" id="tasks_list">
                                <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Task description</th>
                                    <th scope="col">Completed</th>
                                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) : ?>
                                        <th scope="col">Actions</th>
                                    <?php endif; ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['tasks'] as $task): ?>


                                    <tr <?php echo ($task->completed) ? "class='completed'" : '' ?>
                                            id="task_row_<?= $task->id ?>">
                                        <th scope="row"><?= $task->id ?> </th>
                                        <td><?= $task->email ?></td>
                                        <td><?= $task->username ?></td>
                                        <td id="description_<?= $task->id?>"><span id="description_<?= $task->id?>_text"><?= $task->description ?></span><?php if ($task->created_at != $task->updated_at) {
                                                echo "<p class='info'>Edit by admin</p>";
                                            } ?></td>
                                        <td>
                                            <input type="checkbox" data-id="<?= $task->id ?>"
                                                   class="task_completed" <?php echo $task->completed ? 'checked="checked"' : '' ?>>
                                        </td>
                                        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) : ?>
                                            <td>
                                                <button type="submit" data-id="<?= $task->id ?>"
                                                        class="btn btn-secondary edit_task col-10">Edit
                                                </button>
                                                <button type="submit" data-id="<?= $task->id ?>"
                                                        class="btn btn-danger delete_task col-10">Delete
                                                </button>
                                                <button type="submit" data-id="<?= $task->id ?>" id="save_<?= $task->id ?>"
                                                        class="btn btn-success save-task-desc">Save
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <?php for ($i = 1; $i <= $data['pageCount']; $i++): ?>
                                        <li class="page-item"><a
                                                    class="page-link <?php echo $data['currentPage'] == $i ? 'active_page' : '' ?>"
                                                    class="page-link"
                                                    href="<?= getUrlParameters('page') . '&page=' . $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require_once APPROOT . '/src/views/include/footer.php'; ?>