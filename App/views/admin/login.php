<?php $this->setSiteTitle('Login'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <div class="row" style="margin-top: 60px;">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Login</h3></div>
                <div class="panel-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?= e($error) ?></div>
                    <?php endif; ?>
                    <?php if ($message = Application::$session->flash('success')) : ?>
                        <div class="alert alert-success"><?= e($message) ?></div>
                    <?php endif; ?>
                    <form method="post" action="<?= root('admin/login') ?>">
                        <?= csrfInput() ?>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <p class="text-center" style="margin-top: 15px;">
                        <a href="<?= root('admin/register') ?>">Create an account</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
