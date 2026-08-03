<?php $this->setSiteTitle('Posts'); ?>

<?php $this->start('body'); ?>
<div class="card">
    <div class="clearfix" style="margin-bottom: 20px;">
        <h1 class="pull-left" style="margin: 0;">Posts</h1>
        <a href="<?= root('admin/postCreate') ?>" class="btn btn-primary pull-right">+ Add Post</a>
    </div>

    <?php if (empty($posts)) : ?>
        <div class="empty-state">
            <h3>No posts yet</h3>
            <p>Write your first post to get started.</p>
            <a href="<?= root('admin/postCreate') ?>" class="btn btn-primary">Add Post</a>
        </div>
    <?php else : ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) : ?>
                    <tr>
                        <td><strong><?= e($post['title']) ?></strong></td>
                        <td><?= e($post['slug']) ?></td>
                        <td><span class="badge badge-<?= $post['status'] === 'published' ? 'success' : 'warning' ?>"><?= e($post['status']) ?></span></td>
                        <td><?= e($post['created_at']) ?></td>
                        <td class="text-right">
                            <a href="<?= root('posts/show/' . $post['slug']) ?>" class="btn btn-xs btn-info" target="_blank">View</a>
                            <a href="<?= root('admin/postEdit/' . $post['id']) ?>" class="btn btn-xs btn-warning">Edit</a>
                            <a href="<?= root('admin/postDelete/' . $post['id']) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this post?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $this->end(); ?>
