<?php $this->setSiteTitle('Admin Dashboard'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1 class="text-center">Admin Dashboard</h1>
    <p class="text-center">Welcome, <?= e(Application::$session->get('user_name')) ?>!</p>

    <div class="row" style="margin-top: 40px;">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Users</h3>
                </div>
                <div class="panel-body text-center">
                    <h2><?= $userCount ?></h2>
                    <a href="<?= root('admin/users') ?>" class="btn btn-default">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Posts</h3>
                </div>
                <div class="panel-body text-center">
                    <h2><?= $postCount ?></h2>
                    <a href="<?= root('admin/posts') ?>" class="btn btn-default">Manage Posts</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">New Post</h3>
                </div>
                <div class="panel-body text-center">
                    <br>
                    <a href="<?= root('admin/postCreate') ?>" class="btn btn-primary">Create Post</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
