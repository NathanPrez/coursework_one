<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {

   public function basic_email(User $user) {
      $data = array('name'=>"SK8");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to($user->email, 'SK8')->subject
            ('Laravel Basic Testing Mail');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
   }
   
}