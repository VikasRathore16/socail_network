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
    public function followAction()
    {
        if (!isset($_SESSION['friends'])) {
            $_SESSION['friends'] = array();
        }
        $id = $_POST['currentuser'];
        $user_id = $_POST['user_id'];
        $this->view->currentUser = Users::find($id);
        $this->view->user = Users::find($user_id);
        $username = $this->view->user[0]->username;
        $_SESSION['friends'][$user_id] = ['name' => $username ,'status' => 'unmute'];
        $this->view->currentUser[0]->friends =  json_encode($_SESSION['friends']);
        // "{friend : { $user_id : $username }}";
        $this->view->currentUser[0]->save();
        print_r($username);
        die();
    }

    public function unfollowAction()
    {
        if (!isset($_SESSION['friends'])) {
            $_SESSION['friends'] = array();
        }
        $id = $_POST['currentuser'];
        $user_id = $_POST['user_id'];
        $this->view->currentUser = Users::find($id);
        $this->view->user = Users::find($user_id);
        print_r($this->view->user[0]->user_id);
        print_r($this->view->currentUser[0]->friends);
        $friends = json_decode($this->view->currentUser[0]->friends);
        print_r($friends);

        foreach ($friends as $id => $name) {
            if ($user_id == $id) {
                unset($friends->$id);
                print_r($name);
                unset($_SESSION['friends'][$id]);
            }
        }
        $this->view->currentUser[0]->friends =  json_encode($friends);
        $this->view->currentUser[0]->save();
        print_r($friends);
        die();
    }


    public function muteAction()
    {
        if (!isset($_SESSION['friends'])) {
            $_SESSION['friends'] = array();
        }
        $id = $_POST['currentuser'];
        $user_id = $_POST['user_id'];
        $this->view->currentUser = Users::find($id);
        $this->view->user = Users::find($user_id);
        print_r($this->view->user[0]->user_id);
        print_r($this->view->currentUser[0]->friends);
        $friends = json_decode($this->view->currentUser[0]->friends);
        print_r($friends);

        foreach ($friends as $id => $name) {
            if ($user_id == $id) {
                // unset($friends->$id);
                echo "Inside";
                $name->status = 'mute';
                print_r($name);
                // unset($_SESSION['friends'][$id]);
            }
        }
        $this->view->currentUser[0]->friends =  json_encode($friends);
        $this->view->currentUser[0]->save();
        print_r($friends);
        die();
    }


    public function unmuteAction()
    {
        if (!isset($_SESSION['friends'])) {
            $_SESSION['friends'] = array();
        }
        $id = $_POST['currentuser'];
        $user_id = $_POST['user_id'];
        $this->view->currentUser = Users::find($id);
        $this->view->user = Users::find($user_id);
        print_r($this->view->user[0]->user_id);
        print_r($this->view->currentUser[0]->friends);
        $friends = json_decode($this->view->currentUser[0]->friends);
        print_r($friends);

        foreach ($friends as $id => $name) {
            if ($user_id == $id) {
                // unset($friends->$id);
                echo "Inside";
                $name->status = 'unmute';
                print_r($name);
                // unset($_SESSION['friends'][$id]);
            }
        }
        $this->view->currentUser[0]->friends =  json_encode($friends);
        $this->view->currentUser[0]->save();
        print_r($friends);
        die();
    }
}
