<?php $this->setSiteTitle('Not Found'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <div class="text-center" style="margin-top: 80px;">
        <h1 style="font-size: 100px; font-weight: 700; color: var(--primary);">404</h1>
        <h2>Page Not Found</h2>
        <p class="text-muted" style="font-size: 18px;">Sorry, the page you are looking for does not exist.</p>
        <a href="<?= root() ?>" class="btn btn-primary btn-lg">Go Home</a>
    </div>
</div>
<?php $this->end(); ?>
