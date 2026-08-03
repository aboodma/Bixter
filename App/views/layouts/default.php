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
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?= root() ?>"><?= SITE_TITLE ?></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= root() ?>">Home</a></li>
                <li><a href="<?= root('posts') ?>">Posts</a></li>
                <li><a href="<?= root('tools') ?>">Tools</a></li>
                <?php if (Application::$session->has('user_id')) : ?>
                    <li><a href="<?= root('admin') ?>">Admin</a></li>
                    <li><a href="<?= root('admin/logout') ?>">Logout</a></li>
                <?php else : ?>
                    <li><a href="<?= root('admin/login') ?>">Login</a></li>
                    <li><a href="<?= root('admin/register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-bottom: 20px;">
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
    </div>

    <?= $this->content('body') ?>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= SITE_TITLE ?>. Built with Bixter.</p>
        </div>
    </footer>
</body>
</html>
