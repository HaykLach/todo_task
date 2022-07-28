<?php require_once APPROOT . '/src/views/include/header.php'; ?>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card rounded-3">
                        <div class="card-body p-4">

                            <form  action="/login" method="post" autocomplete="on" id="login_form" >
                                <div class="mb-3">
                                    <label for="login" class="form-label">Login</label>
                                    <input type="text" name="login" class="form-control required_form" id="login">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control required_form" id="password">
                                </div>
                                <ul class="error_list">

                                </ul>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require_once APPROOT . '/src/views/include/footer.php'; ?>