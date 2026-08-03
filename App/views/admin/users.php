<?php $this->setSiteTitle('Users'); ?>

<?php $this->start('body'); ?>
<div class="card">
    <div class="clearfix" style="margin-bottom: 20px;">
        <h1 class="pull-left" style="margin: 0;">Users</h1>
        <a href="<?= root('admin/userCreate') ?>" class="btn btn-primary pull-right">+ Add User</a>
    </div>

    <?php if (empty($users)) : ?>
        <div class="empty-state">
            <h3>No users yet</h3>
            <p>Create your first user to get started.</p>
            <a href="<?= root('admin/userCreate') ?>" class="btn btn-primary">Add User</a>
        </div>
    <?php else : ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><strong><?= e($user['username']) ?></strong></td>
                        <td><?= e($user['email']) ?></td>
                        <td><span class="badge badge-<?= $user['role'] === 'admin' ? 'danger' : 'default' ?>"><?= e($user['role']) ?></span></td>
                        <td><?= e($user['created_at']) ?></td>
                        <td class="text-right">
                            <a href="<?= root('admin/user/' . $user['id']) ?>" class="btn btn-xs btn-info">View</a>
                            <a href="<?= root('admin/userEdit/' . $user['id']) ?>" class="btn btn-xs btn-warning">Edit</a>
                            <a href="<?= root('admin/userDelete/' . $user['id']) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $this->end(); ?>
