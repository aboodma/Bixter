<?php $this->setSiteTitle('Users'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1>Users</h1>
    <a href="<?= root('admin/userCreate') ?>" class="btn btn-primary" style="margin-bottom: 20px;">Add User</a>

    <?php if ($message = Application::$session->flash('success')) : ?>
        <div class="alert alert-success"><?= e($message) ?></div>
    <?php endif; ?>
    <?php if ($message = Application::$session->flash('error')) : ?>
        <div class="alert alert-danger"><?= e($message) ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= e($user['username']) ?></td>
                    <td><?= e($user['email']) ?></td>
                    <td><?= e($user['role']) ?></td>
                    <td><?= e($user['created_at']) ?></td>
                    <td>
                        <a href="<?= root('admin/user/' . $user['id']) ?>" class="btn btn-xs btn-info">View</a>
                        <a href="<?= root('admin/userEdit/' . $user['id']) ?>" class="btn btn-xs btn-warning">Edit</a>
                        <a href="<?= root('admin/userDelete/' . $user['id']) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->end(); ?>
