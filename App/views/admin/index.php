<?php $this->setSiteTitle('Admin Dashboard'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1 class="text-center">Admin Dashboard</h1>
    <p class="text-center">Welcome, <?= e(Application::$session->get('user_name')) ?>!</p>
    <p class="text-center">
        <a href="<?= root('admin/logout') ?>" class="btn btn-danger">Logout</a>
    </p>
</div>
<?php $this->end(); ?>
