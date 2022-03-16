<?php

namespace App\Controller;

use App\Model\User;
use App\View;

class LoginController
{

    public function loginForm()
    {
        if(isset($_SESSION['flash_message']))
        {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }

        return View::make('auth/login', ['message' => $message ?? null]);
    }

    public function login()
    {
        // Now we check if the data from the login form was submitted, isset() will check if the data exists.
        if ( !isset($_POST['username'], $_POST['password']) || (empty($_POST['username']) || empty($_POST['password'])))  {
                // Could not get the data that should have been sent.
                $_SESSION['flash_message'] = 'Please fill both the username and password fields!';

                header('Location: /login');

                exit;
        }

        $user = new User();
        $user = $user->find($_POST['username']);

        if(! ($user && password_verify($_POST['password'], $user['password'])) ){
            $_SESSION['flash_message'] = $user ? 'Notfound User!' : 'Unvalid Password!';
            header('Location: /login');

            exit;
        }

        $_SESSION['AUTH'] = true;
        $_SESSION['AUTH_USER'] = $user;
        header('Location: /');
        exit;
    }

    public function logout()
    {
        session_destroy();

        header('Location: /login');

        exit;
    }
}