<?php

namespace App\Controllers\Web;

use Polly\Core\Authentication;
use Polly\Core\Message;
use Polly\Core\Request;
use Polly\Core\Session;

class Login extends BaseController
{
    public function index()
    {
        if(Authentication::check())
        {
            $this->response->redirect('index');
            return;
        }
        $this->response->setViewOnly();
        $this->response->view('Login/Index');
    }

    public function try()
    {
        if(Authentication::login(Request::post('username') ?: "", Request::post('password') ?: ""))
        {
            Session::addMessage(new Message(Message::SUCCESS, translate('login_success_title'), translate('login_success_message')));

            if(isset($_GET['origin']))
            {
                $this->response->redirect($_GET['origin'], false);
            }
            else
            {
                $this->response->redirect('index');
            }
        }
        else
        {
            Session::addMessage(new Message(Message::DANGER, translate('login_failed_title'), translate('login_failed_message')));
            $this->response->redirect((Request::get('origin') ?: '?origin='.Request::get('origin')), false);
        }
    }

    public function destroy()
    {
        Authentication::logout();
        $this->response->redirect('index');
    }
}
