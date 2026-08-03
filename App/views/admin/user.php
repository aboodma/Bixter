<?php $this->setSiteTitle('User Details'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <?php if ($user) : ?>
        <h1><?= e($user['username']) ?></h1>
        <p>Email: <?= e($user['email']) ?></p>
        <p>Role: <?= e($user['role']) ?></p>
        <p>Joined: <?= e($user['created_at']) ?></p>
    <?php else : ?>
        <h1>User not found</h1>
    <?php endif; ?>
</div>
<?php $this->end(); ?>
