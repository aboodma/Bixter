<?php

declare(strict_types=1);

namespace Bixter\App\Controllers;

use Bixter\Core\Controller;
use Bixter\Core\Application;
use Bixter\App\Models\User;
use Bixter\App\Models\Post;

class Admin extends Controller
{
    protected User $_user;
    protected Post $_post;

    public function __construct(string $controller, string $action)
    {
        parent::__construct($controller, $action);
        $this->view->setLayout('admin');
        $this->_user = new User();
        $this->_post = new Post();
    }

    public function indexAction(): void
    {
        $this->_requireAuth();

        $this->view->assign('userCount', count($this->_user->findAll()));
        $this->view->assign('postCount', count($this->_post->findAll()));
        $this->view->render('admin/index');
    }

    public function loginAction(): void
    {
        if (Application::$session->has('user_id')) {
            redirect(root('admin'));
        }

        if ($this->request->isPost()) {
            $email = $this->request->post('email');
            $password = $this->request->post('password');
            $user = $this->_user->login($email, $password);

            if ($user) {
                Application::$session->set('user_id', $user['id']);
                Application::$session->set('user_name', $user['username']);
                Application::$session->set('user_role', $user['role']);
                Application::$session->regenerate();
                redirect(root('admin'));
            }

            $this->view->assign('error', 'Invalid email or password.');
        }

        $this->view->setLayout('auth');
        $this->view->render('admin/login');
    }

    public function registerAction(): void
    {
        if (Application::$session->has('user_id')) {
            redirect(root('admin'));
        }

        if ($this->request->isPost()) {
            $data = [
                'username' => $this->request->post('username'),
                'email' => $this->request->post('email'),
                'password' => $this->request->post('password'),
            ];

            if ($this->_user->validate($data)) {
                if ($this->_user->register($data)) {
                    Application::$session->flash('success', 'Account created. Please log in.');
                    redirect(root('admin/login'));
                }
                $this->view->assign('error', 'Email already exists.');
            } else {
                $this->view->assign('errors', $this->_user->getErrors());
            }

            $this->view->assign('data', $data);
        }

        $this->view->setLayout('auth');
        $this->view->render('admin/register');
    }

    public function logoutAction(): void
    {
        Application::$session->destroy();
        redirect(root('admin/login'));
    }

    public function usersAction(): void
    {
        $this->_requireAuth();
        $this->view->assign('users', $this->_user->findAll());
        $this->view->render('admin/users');
    }

    public function userCreateAction(): void
    {
        $this->_requireAuth();

        if ($this->request->isPost()) {
            $data = [
                'username' => $this->request->post('username'),
                'email' => $this->request->post('email'),
                'password' => $this->request->post('password'),
                'role' => $this->request->post('role', 'user'),
            ];

            if ($this->_user->validate($data)) {
                if ($this->_user->register($data)) {
                    Application::$session->flash('success', 'User created.');
                    redirect(root('admin/users'));
                }
                $this->view->assign('error', 'Email already exists.');
            } else {
                $this->view->assign('errors', $this->_user->getErrors());
            }

            $this->view->assign('data', $data);
        }

        $this->view->render('admin/user_form');
    }

    public function userEditAction(int $id): void
    {
        $this->_requireAuth();

        $user = $this->_user->findById($id);
        if (!$user) {
            Application::$session->flash('error', 'User not found.');
            redirect(root('admin/users'));
        }

        if ($this->request->isPost()) {
            $data = [
                'username' => $this->request->post('username'),
                'email' => $this->request->post('email'),
                'role' => $this->request->post('role', 'user'),
            ];

            if ($this->_user->validate($data)) {
                $this->_user->update($id, $data);
                Application::$session->flash('success', 'User updated.');
                redirect(root('admin/users'));
            }

            $this->view->assign('errors', $this->_user->getErrors());
            $this->view->assign('data', $data);
        } else {
            $this->view->assign('data', $user);
        }

        $this->view->assign('id', $id);
        $this->view->render('admin/user_form');
    }

    public function userDeleteAction(int $id): void
    {
        $this->_requireAuth();
        $this->_user->delete($id);
        Application::$session->flash('success', 'User deleted.');
        redirect(root('admin/users'));
    }

    public function postsAction(): void
    {
        $this->_requireAuth();
        $this->view->assign('posts', $this->_post->findAll());
        $this->view->render('admin/posts');
    }

    public function postCreateAction(): void
    {
        $this->_requireAuth();

        if ($this->request->isPost()) {
            $data = $this->_postData();

            if ($this->_post->validate($data)) {
                $this->_post->insert($data);
                Application::$session->flash('success', 'Post created.');
                redirect(root('admin/posts'));
            }

            $this->view->assign('errors', $this->_post->getErrors());
            $this->view->assign('data', $data);
        } else {
            $this->view->assign('data', ['status' => 'draft']);
        }

        $this->view->render('admin/post_form');
    }

    public function postEditAction(int $id): void
    {
        $this->_requireAuth();

        $post = $this->_post->findById($id);
        if (!$post) {
            Application::$session->flash('error', 'Post not found.');
            redirect(root('admin/posts'));
        }

        if ($this->request->isPost()) {
            $data = $this->_postData();

            if ($this->_post->validate($data)) {
                $this->_post->update($id, $data);
                Application::$session->flash('success', 'Post updated.');
                redirect(root('admin/posts'));
            }

            $this->view->assign('errors', $this->_post->getErrors());
            $this->view->assign('data', $data);
        } else {
            $this->view->assign('data', $post);
        }

        $this->view->assign('id', $id);
        $this->view->render('admin/post_form');
    }

    public function postDeleteAction(int $id): void
    {
        $this->_requireAuth();
        $this->_post->delete($id);
        Application::$session->flash('success', 'Post deleted.');
        redirect(root('admin/posts'));
    }

    public function userAction(int $id): void
    {
        $this->_requireAuth();
        $user = $this->_user->findById($id);
        $this->view->assign('user', $user);
        $this->view->render('admin/user');
    }

    public function deleteAction(int $id): void
    {
        $this->_requireAuth();
        $this->_user->delete($id);
        Application::$session->flash('success', 'User deleted.');
        redirect(root('admin/users'));
    }

    private function _requireAuth(): void
    {
        if (!Application::$session->has('user_id')) {
            redirect(root('admin/login'));
        }
    }

    private function _postData(): array
    {
        return [
            'title' => $this->request->post('title'),
            'slug' => $this->request->post('slug'),
            'content' => $this->request->post('content'),
            'status' => $this->request->post('status', 'draft'),
        ];
    }
}
