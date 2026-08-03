<?php $this->setSiteTitle('Blog Posts'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1 class="text-center">Latest Posts</h1>

    <?php if (empty($posts)) : ?>
        <p class="text-center text-muted">No posts yet.</p>
    <?php else : ?>
        <?php foreach ($posts as $post) : ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2><a href="<?= root('posts/show/' . $post['slug']) ?>"><?= e($post['title']) ?></a></h2>
                    <p class="text-muted"><?= e($post['created_at']) ?></p>
                    <p><?= e(substr($post['content'], 0, 200)) ?><?= strlen($post['content']) > 200 ? '...' : '' ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php $this->end(); ?>
