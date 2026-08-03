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
    <?= $this->content('body') ?>
</body>
</html>
