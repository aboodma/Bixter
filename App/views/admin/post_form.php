<?php $this->setSiteTitle(isset($id) ? 'Edit Post' : 'New Post'); ?>

<?php $this->start('body'); ?>
<div class="card">
    <h1 style="margin-top: 0;"><?= isset($id) ? 'Edit Post' : 'New Post' ?></h1>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <?= csrfInput() ?>
        <div class="row">
            <div class="col-md-8 form-group <?= isset($errors['title']) ? 'has-error' : '' ?>">
                <label>Title</label>
                <input type="text" name="title" value="<?= e($data['title'] ?? '') ?>" class="form-control" placeholder="Post title">
                <?php if (isset($errors['title'])) : ?>
                    <span class="help-block"><?= e($errors['title']) ?></span>
                <?php endif; ?>
            </div>
            <div class="col-md-4 form-group <?= isset($errors['slug']) ? 'has-error' : '' ?>">
                <label>Slug</label>
                <input type="text" name="slug" value="<?= e($data['slug'] ?? '') ?>" class="form-control" placeholder="post-slug">
                <?php if (isset($errors['slug'])) : ?>
                    <span class="help-block"><?= e($errors['slug']) ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group <?= isset($errors['content']) ? 'has-error' : '' ?>">
            <label>Content</label>
            <textarea name="content" rows="12" class="form-control" placeholder="Write your post here..."><?= e($data['content'] ?? '') ?></textarea>
            <?php if (isset($errors['content'])) : ?>
                <span class="help-block"><?= e($errors['content']) ?></span>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-md-3 form-group <?= isset($errors['status']) ? 'has-error' : '' ?>">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="draft" <?= ($data['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="published" <?= ($data['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
                </select>
                <?php if (isset($errors['status'])) : ?>
                    <span class="help-block"><?= e($errors['status']) ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save Post</button>
            <a href="<?= root('admin/posts') ?>" class="btn btn-default">Cancel</a>
        </div>
    </form>
</div>
<?php $this->end(); ?>
