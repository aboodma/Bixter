<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->siteTitle() ?></title>
    <link rel="stylesheet" href="<?= PROOT ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PROOT ?>css/custom.css">
    <script src="<?= PROOT ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?= PROOT ?>js/bootstrap.min.js"></script>
    <?= $this->content('head') ?>
</head>
<body>
    <nav class="navbar navbar-default" style="margin-bottom: 0;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?= root('admin') ?>"><?= SITE_TITLE ?></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= root() ?>" target="_blank">View Site</a></li>
                <li><a href="<?= root('admin/logout') ?>">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="brand">Admin</div>
            <ul class="nav nav-pills nav-stacked">
                <li class="<?= $_SERVER['REQUEST_URI'] === root('admin') ? 'active' : '' ?>"><a href="<?= root('admin') ?>">Dashboard</a></li>
                <li class="<?= strpos($_SERVER['REQUEST_URI'] ?? '', root('admin/users')) !== false ? 'active' : '' ?>"><a href="<?= root('admin/users') ?>">Users</a></li>
                <li class="<?= strpos($_SERVER['REQUEST_URI'] ?? '', root('admin/posts')) !== false ? 'active' : '' ?>"><a href="<?= root('admin/posts') ?>">Posts</a></li>
                <li><a href="<?= root('admin/userCreate') ?>">+ Add User</a></li>
                <li><a href="<?= root('admin/postCreate') ?>">+ Add Post</a></li>
            </ul>
        </aside>

        <main class="admin-main">
            <?php if ($message = Application::$session->flash('success')) : ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?= e($message) ?>
                </div>
            <?php endif; ?>
            <?php if ($message = Application::$session->flash('error')) : ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?= e($message) ?>
                </div>
            <?php endif; ?>

            <?= $this->content('body') ?>
        </main>
    </div>
</body>
</html>
