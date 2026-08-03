<?php $this->setSiteTitle('Login'); ?>

<?php $this->start('body'); ?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">Welcome back</h3></div>
    <div class="panel-body">
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= root('admin/login') ?>">
            <?= csrfInput() ?>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <p class="text-center" style="margin-top: 20px; margin-bottom: 0;">
            <a href="<?= root('admin/register') ?>">Create an account</a>
        </p>
    </div>
</div>
<?php $this->end(); ?>
