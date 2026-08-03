<?php $this->setSiteTitle(e($post['title'])); ?>

<?php $this->start('body'); ?>
<div class="container">
    <article class="card" style="padding: 40px;">
        <h1 style="margin-top: 0;"><?= e($post['title']) ?></h1>
        <p class="text-muted">Published on <?= e($post['created_at']) ?></p>
        <hr>
        <div style="font-size: 17px; line-height: 1.8;">
            <?= nl2br(e($post['content'])) ?>
        </div>
        <hr style="margin-top: 40px;">
        <a href="<?= root('posts') ?>" class="btn btn-default">&larr; Back to posts</a>
    </article>
</div>
<?php $this->end(); ?>
