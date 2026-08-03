<?php

declare(strict_types=1);

use Bixter\App\Middleware\AuthMiddleware;

Router::get('/', 'Home@indexAction');
Router::get('/home', 'Home@indexAction');

Router::get('/tools', 'Tools@indexAction');
Router::get('/tools/first', 'Tools@firstAction');
Router::get('/tools/second', 'Tools@secondAction');
Router::get('/tools/third', 'Tools@thirdAction');

Router::get('/posts', 'Posts@indexAction');
Router::get('/posts/show/{slug}', 'Posts@showAction');

// Auth
Router::get('/admin/login', 'Admin@loginAction');
Router::post('/admin/login', 'Admin@loginAction');
Router::get('/admin/register', 'Admin@registerAction');
Router::post('/admin/register', 'Admin@registerAction');

// Admin
Router::group(['prefix' => '/admin', 'middleware' => [AuthMiddleware::class]], function () {
    Router::get('/', 'Admin@indexAction');
    Router::get('/logout', 'Admin@logoutAction');
    Router::get('/users', 'Admin@usersAction');
    Router::get('/user/{id}', 'Admin@userAction');
    Router::get('/userCreate', 'Admin@userCreateAction');
    Router::post('/userCreate', 'Admin@userCreateAction');
    Router::get('/userEdit/{id}', 'Admin@userEditAction');
    Router::post('/userEdit/{id}', 'Admin@userEditAction');
    Router::get('/userDelete/{id}', 'Admin@userDeleteAction');

    Router::get('/posts', 'Admin@postsAction');
    Router::get('/postCreate', 'Admin@postCreateAction');
    Router::post('/postCreate', 'Admin@postCreateAction');
    Router::get('/postEdit/{id}', 'Admin@postEditAction');
    Router::post('/postEdit/{id}', 'Admin@postEditAction');
    Router::get('/postDelete/{id}', 'Admin@postDeleteAction');
});
