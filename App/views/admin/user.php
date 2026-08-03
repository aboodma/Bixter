<?php $this->setSiteTitle('User Details'); ?>

<?php $this->start('body'); ?>
<div class="card">
    <?php if ($user) : ?>
        <h1 style="margin-top: 0;"><?= e($user['username']) ?></h1>
        <p><span class="badge badge-<?= $user['role'] === 'admin' ? 'danger' : 'default' ?>"><?= e($user['role']) ?></span></p>
        <p><strong>Email:</strong> <?= e($user['email']) ?></p>
        <p><strong>Joined:</strong> <?= e($user['created_at']) ?></p>
        <p><a href="<?= root('admin/users') ?>" class="btn btn-default">&larr; Back to users</a></p>
    <?php else : ?>
        <div class="empty-state">
            <h3>User not found</h3>
            <a href="<?= root('admin/users') ?>" class="btn btn-default">Back to users</a>
        </div>
    <?php endif; ?>
</div>
<?php $this->end(); ?>
