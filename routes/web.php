<?php

declare(strict_types=1);

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
Router::get('/admin/logout', 'Admin@logoutAction');

// Admin (requires login)
Router::get('/admin', 'Admin@indexAction');
Router::get('/admin/users', 'Admin@usersAction');
Router::get('/admin/user/{id}', 'Admin@userAction');
Router::get('/admin/userCreate', 'Admin@userCreateAction');
Router::post('/admin/userCreate', 'Admin@userCreateAction');
Router::get('/admin/userEdit/{id}', 'Admin@userEditAction');
Router::post('/admin/userEdit/{id}', 'Admin@userEditAction');
Router::get('/admin/userDelete/{id}', 'Admin@userDeleteAction');

Router::get('/admin/posts', 'Admin@postsAction');
Router::get('/admin/postCreate', 'Admin@postCreateAction');
Router::post('/admin/postCreate', 'Admin@postCreateAction');
Router::get('/admin/postEdit/{id}', 'Admin@postEditAction');
Router::post('/admin/postEdit/{id}', 'Admin@postEditAction');
Router::get('/admin/postDelete/{id}', 'Admin@postDeleteAction');
