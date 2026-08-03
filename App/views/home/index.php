<?php $this->setSiteTitle('Home'); ?>

<?php $this->start('body'); ?>
<div class="jumbotron text-center">
    <div class="container">
        <h1>Welcome to Bixter</h1>
        <p class="lead">A lightweight, fast, full-stack PHP framework built for the future.</p>
        <p>
            <a class="btn btn-primary btn-lg" href="<?= root('admin/register') ?>" style="margin-right: 10px;">Get Started</a>
            <a class="btn btn-default btn-lg" href="<?= root('posts') ?>" style="background: rgba(255,255,255,0.2); color: #fff; border: none;">Read Posts</a>
        </p>
    </div>
</div>

<div class="container">
    <div class="row text-center" style="margin-bottom: 40px;">
        <div class="col-md-4">
            <div class="card">
                <h3>Fast</h3>
                <p class="text-muted">Minimal overhead with lazy loading and compiled routes.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Simple</h3>
                <p class="text-muted">No magic, no Facades. Explicit, understandable PHP.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Modern</h3>
                <p class="text-muted">PHP 8.4, PSR-4, typed properties, and a clean API.</p>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
