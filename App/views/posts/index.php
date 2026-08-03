<?php $this->setSiteTitle('Blog Posts'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1 class="text-center" style="margin-bottom: 40px;">Latest Posts</h1>

    <?php if (empty($posts)) : ?>
        <div class="empty-state card">
            <h3>No posts yet</h3>
            <p class="text-muted">Check back soon for new content.</p>
        </div>
    <?php else : ?>
        <?php foreach ($posts as $post) : ?>
            <div class="card post-card">
                <h2><a href="<?= root('posts/show/' . $post['slug']) ?>"><?= e($post['title']) ?></a></h2>
                <p class="text-muted">Published on <?= e($post['created_at']) ?></p>
                <p><?= e(substr($post['content'], 0, 250)) ?><?= strlen($post['content']) > 250 ? '...' : '' ?></p>
                <a href="<?= root('posts/show/' . $post['slug']) ?>" class="btn btn-primary btn-sm">Read More</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php $this->end(); ?>
