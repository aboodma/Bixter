<?php $this->setSiteTitle('Tool One'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <div class="card text-center">
        <h1>Tool One</h1>
        <p class="text-muted">This is the first demo tool.</p>
        <a href="<?= root('tools') ?>" class="btn btn-default">&larr; Back to tools</a>
    </div>
</div>
<?php $this->end(); ?>
