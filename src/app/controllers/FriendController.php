<?php

use Phalcon\Mvc\Controller;


class FriendController extends Controller
{
    public function indexAction()
    {
        $user_id = $_GET['user_id'];
        $this->view->currentUser = Users::find($user_id);
        $this->view->users = Users::find();
    }
    public function followAction(){
        $id = $_POST['currentuser'];
        $user_id = $_POST['user_id'];
        $this->view->currentUser = Users::find($id);
        $this->view->user = Users::find($user_id);
        $username = $this->view->user[0]->username;
        $this->view->currentUser[0]->friends =  '{
            "friend":{ "'.$user_id.'":"'.$username.'"}
            }';
        // "{friend : { $user_id : $username }}";
        $this->view->currentUser[0]->save();
        print_r($username);
        die();
    }
}
