<?php $this->setSiteTitle(e($post['title'])); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1><?= e($post['title']) ?></h1>
    <p class="text-muted"><?= e($post['created_at']) ?></p>
    <hr>
    <p><?= nl2br(e($post['content'])) ?></p>
    <a href="<?= root('posts') ?>" class="btn btn-default">&larr; Back to posts</a>
</div>
<?php $this->end(); ?>
