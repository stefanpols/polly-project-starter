<?php

namespace App\Controllers\Web;

use App\Services\UserService;
use Polly\Core\Message;
use Polly\Helpers\Str;
use Polly\ORM\Types\DateTime;

class User extends BaseController
{
    public function index()
    {
        $this->response->users = UserService::all();
        $this->response->view('User/Index');
    }

    public function delete(string $id)
    {
        UserService::delete($user = UserService::findById($id));
        \Polly\Core\Session::addMessage(new Message(Message::SUCCESS, 'User deleted', $user->getUsername()." is deleted successfully."));
        $this->response->redirect('user');
    }

    public function create()
    {
        $user = new \App\Models\User();
        $user->setFirstname(Str::random(10));
        $user->setLastname(Str::random(10));
        $user->setUsername(Str::random(10)."@codens.nl");
        $user->setPassword(password_hash(Str::random(10), PASSWORD_DEFAULT));
        $user->setCreated(new DateTime());
        $user->setActive(1);
        UserService::save($user);

        \Polly\Core\Session::addMessage(new Message(Message::SUCCESS, 'User created', $user->getUsername()." is created successfully."));

        $this->response->redirect('user');

    }

}