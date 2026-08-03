<?php $this->setSiteTitle(isset($id) ? 'Edit User' : 'New User'); ?>

<?php $this->start('body'); ?>
<div class="card">
    <h1 style="margin-top: 0;"><?= isset($id) ? 'Edit User' : 'New User' ?></h1>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <?= csrfInput() ?>
        <div class="row">
            <div class="col-md-6 form-group <?= isset($errors['username']) ? 'has-error' : '' ?>">
                <label>Username</label>
                <input type="text" name="username" value="<?= e($data['username'] ?? '') ?>" class="form-control">
                <?php if (isset($errors['username'])) : ?>
                    <span class="help-block"><?= e($errors['username']) ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-6 form-group <?= isset($errors['email']) ? 'has-error' : '' ?>">
                <label>Email</label>
                <input type="email" name="email" value="<?= e($data['email'] ?? '') ?>" class="form-control">
                <?php if (isset($errors['email'])) : ?>
                    <span class="help-block"><?= e($errors['email']) ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group <?= isset($errors['password']) ? 'has-error' : '' ?>">
                <label>Password <?= isset($id) ? '(leave blank to keep current)' : '' ?></label>
                <input type="password" name="password" class="form-control">
                <?php if (isset($errors['password'])) : ?>
                    <span class="help-block"><?= e($errors['password']) ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-6 form-group">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="user" <?= ($data['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= ($data['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= root('admin/users') ?>" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
<?php $this->end(); ?>
