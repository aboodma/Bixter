<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <div class="jumbotron text-center">
        <h1>Hello from Bixter</h1>
        <p class="lead">A modern PHP MVC framework built from your old starter project.</p>
        <a class="btn btn-primary btn-lg" href="<?= root('admin/register') ?>">Get Started</a>
    </div>
</div>
<?php $this->end(); ?>
