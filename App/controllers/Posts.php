<?php

declare(strict_types=1);

namespace Bixter\App\Controllers;

use Bixter\Core\Controller;
use Bixter\App\Models\Post;

class Posts extends Controller
{
    protected Post $_post;

    public function __construct(string $controller, string $action)
    {
        parent::__construct($controller, $action);
        $this->_post = new Post();
    }

    public function indexAction(): void
    {
        $this->view->assign('posts', $this->_post->findPublished());
        $this->view->render('posts/index');
    }

    public function showAction(string $slug): void
    {
        $post = $this->_post->findBySlug($slug);
        if (!$post) {
            http_response_code(404);
            $this->view->render('errors/404');
            return;
        }
        $this->view->assign('post', $post);
        $this->view->render('posts/show');
    }
}
