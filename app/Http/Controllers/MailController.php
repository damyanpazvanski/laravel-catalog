<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class MailController extends Controller
{
    public function send(\Illuminate\Mail\Mailer $mailer)
    {
        $description = Input::get('description');
        $name = Input::get('name');
        $app = include '/../../../config/app.php';

        if (!$description || !$name) {
            return Redirect::to(URL::previous());
        }

        $mailer->to($app['ADMINISTRATOR_EMAIL'])->send(new \App\Mail\MyMail($description, $name));

        return Redirect::to(URL::previous())->with('message', 'You sended a email successfully.');
    }
}
