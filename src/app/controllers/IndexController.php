<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
    }

    public function feedsAction()
    {
        $user_id = $_GET['user_id'];
        $value = $_GET['value'];
        // echo $value;

        if ($value == 'my-feed') {
            // echo $value;

            $this->view->currentUser = Users::find($user_id);
            $postArr = array();
            $posts =  Posts::find("post_user_id = " . $this->view->currentUser[0]->user_id . "");
            print_r(count($posts));
            foreach ($posts as $post){
                array_push($postArr, $post);
            }
           
            $this->view->posts = $postArr;
             print_r($this->view->currentUser[0]);
            print_r($this->view->posts[0]);
             die();
        } else {

            $this->view->currentUser = Users::find($user_id);
            $currentUser = $this->view->currentUser;
            $friendsArr = array();
            $postArr = array();
            foreach (json_decode($currentUser[0]->friends) as $key => $friend) {
                print_r($key);
                $userfriend = Users::find($key);
                $post = Posts::find("post_user_id = " . $key . "");
                // $comment = Comments::find("comment_user_id = " . $key . "");
                array_push($friendsArr, $userfriend);
                array_push($postArr, $post);
            }
            $this->view->users = $friendsArr;
            $this->view->posts = $postArr;
            $this->view->comments = Comments::find();
        }
    }

    public function newpostAction()
    {
        $newPost = $this->request->getPost();
        print_r($newPost);
        $newPost = new Posts();

        $newPost->assign(
            $this->request->getPost(),
            [
                'post_user_id',
                'post_username',
                'title',
                'description',
                'file_path'

            ]
        );

        $success = $newPost->save();

        $this->view->success = $success;

        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register succesfully due to following reason: <br>" . implode("<br>", $newPost->getMessages());
        }
        print_r($newPost);
    }

    public function likeAction()
    {
        $post_id = $_GET['post_id'];
        $user_id = $_GET['user_id'];
        $this->view->post = Posts::find($post_id);
        $this->view->post[0]->likes++;
        $this->view->post[0]->save();
        header("Location: http://localhost:8080/index/feeds?user_id=" . $user_id);
    }

    public function commentAction()
    {
        print_r($this->request->getPost());
        $user_id = $this->request->getPost('user_id');
        $username = $this->request->getPost('username');
        $post_user_id = $this->request->getPost('post_user_id');
        $comment = $this->request->getPost('comment');

        // die();
        // $newPost = $this->request->getPost();
        // print_r($newPost);
        $newcomment = new Comments();
        // die();
        $newcomment->comment_user_id = $user_id;
        $newcomment->comment_post_id = $post_user_id;
        $newcomment->username = $username;
        $newcomment->comment = $comment;
        $newcomment->assign([$user_id, $post_user_id, $comment, $username]);
        // print_r($newcomment);
        $newcomment->save();
        header("Location: http://localhost:8080/index/feeds?user_id=" . $user_id);

        // print_r($newPost);
        // $post_id = $_GET['post_id'];
        // $user_id = $_GET['user_id'];
        // $this->view->post = Posts::find($post_id);
        // $this->view->post[0]->likes++;
        // $this->view->post[0]->save();
        // header("Location: http://localhost:8080/index/feeds?user_id=".$user_id);
    }

    public function editAction($id)
    {
        print_r($id);
        $this->view->users = Users::find($id);
    }
    public function updateAction()
    {

        $id = $this->request->getPost('id');

        $this->view->users = Users::find($id);

        $name = $this->request->getPost('name');
        $this->view->users[0]->name = $name;
        $email = $this->request->getPost('email');
        $this->view->users[0]->email = $email;
        $this->view->users[0]->save();
        header('Location: http://localhost:8080/');
    }
    public function deleteAction($id)
    {
        print_r($id);
        $this->view->users = Users::find($id);
        $this->view->users->delete();
        header('Location: http://localhost:8080/');
    }
}
