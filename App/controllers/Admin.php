<?php

declare(strict_types=1);

class Admin extends Controller
{
    protected User $_user;

    public function __construct(string $controller, string $action)
    {
        parent::__construct($controller, $action);
        $this->_user = new User();
    }

    public function indexAction(): void
    {
        if (!Application::$session->has('user_id')) {
            redirect(root('admin/login'));
        }
        $this->view->render('admin/index');
    }

    public function loginAction(): void
    {
        if ($this->request->isPost()) {
            $email = $this->request->post('email');
            $password = $this->request->post('password');
            $user = $this->_user->login($email, $password);

            if ($user) {
                Application::$session->set('user_id', $user['id']);
                Application::$session->set('user_name', $user['username']);
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

    public function userAction(int $id): void
    {
        if (!Application::$session->has('user_id')) {
            redirect(root('admin/login'));
        }
        $user = $this->_user->findById($id);
        $this->view->assign('user', $user);
        $this->view->render('admin/user');
    }

    public function deleteAction(int $id): void
    {
        if (!Application::$session->has('user_id')) {
            redirect(root('admin/login'));
        }
        $this->_user->delete($id);
        redirect(root('admin'));
    }
}
