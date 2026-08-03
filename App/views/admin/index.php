<?php $this->setSiteTitle('Dashboard'); ?>

<?php $this->start('body'); ?>
<h1 class="page-title">Dashboard</h1>
<p class="text-muted">Welcome back, <?= e(Application::$session->get('user_name')) ?>.</p>

<div class="row" style="margin-top: 30px;">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="stat-label">Users</div>
            <h2><?= $userCount ?></h2>
            <a href="<?= root('admin/users') ?>" class="btn btn-primary btn-sm">Manage Users</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="stat-label">Posts</div>
            <h2><?= $postCount ?></h2>
            <a href="<?= root('admin/posts') ?>" class="btn btn-primary btn-sm">Manage Posts</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="stat-label">New Post</div>
            <h2>+</h2>
            <a href="<?= root('admin/postCreate') ?>" class="btn btn-primary btn-sm">Create Post</a>
        </div>
    </div>
</div>
<?php $this->end(); ?>
