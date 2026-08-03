<?php $this->setSiteTitle('Tools'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1 class="text-center" style="margin-bottom: 40px;">Tools</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <h3>Tool One</h3>
                <p class="text-muted">First demo tool.</p>
                <a href="<?= root('tools/first') ?>" class="btn btn-primary">Open</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <h3>Tool Two</h3>
                <p class="text-muted">Second demo tool.</p>
                <a href="<?= root('tools/second') ?>" class="btn btn-primary">Open</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <h3>Tool Three</h3>
                <p class="text-muted">Third demo tool.</p>
                <a href="<?= root('tools/third') ?>" class="btn btn-primary">Open</a>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
