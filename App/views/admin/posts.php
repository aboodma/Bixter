<?php $this->setSiteTitle('Posts'); ?>

<?php $this->start('body'); ?>
<div class="container">
    <h1>Posts</h1>
    <a href="<?= root('admin/postCreate') ?>" class="btn btn-primary" style="margin-bottom: 20px;">Add Post</a>

    <?php if ($message = Application::$session->flash('success')) : ?>
        <div class="alert alert-success"><?= e($message) ?></div>
    <?php endif; ?>
    <?php if ($message = Application::$session->flash('error')) : ?>
        <div class="alert alert-danger"><?= e($message) ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <td><?= $post['id'] ?></td>
                    <td><?= e($post['title']) ?></td>
                    <td><?= e($post['slug']) ?></td>
                    <td><span class="label label-<?= $post['status'] === 'published' ? 'success' : 'default' ?>"><?= e($post['status']) ?></span></td>
                    <td><?= e($post['created_at']) ?></td>
                    <td>
                        <a href="<?= root('admin/postEdit/' . $post['id']) ?>" class="btn btn-xs btn-warning">Edit</a>
                        <a href="<?= root('admin/postDelete/' . $post['id']) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this post?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->end(); ?>
