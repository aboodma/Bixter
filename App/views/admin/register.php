<?php $this->setSiteTitle('Register'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <div class="row" style="margin-top: 60px;">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Create Account</h3></div>
                <div class="panel-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?= e($error) ?></div>
                    <?php endif; ?>
                    <form method="post" action="<?= root('admin/register') ?>">
                        <?= csrfInput() ?>
                        <div class="form-group <?= isset($errors['username']) ? 'has-error' : '' ?>">
                            <label>Username</label>
                            <input type="text" name="username" value="<?= e($data['username'] ?? '') ?>" class="form-control" required>
                            <?php if (isset($errors['username'])) : ?>
                                <span class="help-block"><?= e($errors['username']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?= isset($errors['email']) ? 'has-error' : '' ?>">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= e($data['email'] ?? '') ?>" class="form-control" required>
                            <?php if (isset($errors['email'])) : ?>
                                <span class="help-block"><?= e($errors['email']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group <?= isset($errors['password']) ? 'has-error' : '' ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <?php if (isset($errors['password'])) : ?>
                                <span class="help-block"><?= e($errors['password']) ?></span>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <p class="text-center" style="margin-top: 15px;">
                        <a href="<?= root('admin/login') ?>">Already have an account?</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
