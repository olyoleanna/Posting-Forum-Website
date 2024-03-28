<?php
require('model.php');

if (empty($_POST['page'])) {
    $display_modal_window = 'none';
    include('startpage.php');
    exit();
}

session_start();

if ($_POST['page'] == 'StartPage' && isset($_POST['command'])) {
    
    // signing up
    if ($_POST['command'] == 'SignUp') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        
        if (isUsernameExists($username)) {
            $error_username = 'Username already exists';
            $display_modal_window = 'signup';
        } else {
            if (insertUser($username, $password, $email)) {
                $display_modal_window = 'signin';
                $_SESSION['username'] = $username;
                include('mainpage.php');
            } else {
                $error_username = 'Sign up failed';
                $display_modal_window = 'signup';
            }
        }
        include('startpage.php');
        exit();
    } 
    
    // logging in
    else if ($_POST['command'] == 'SignIn') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if (!isValidCredentials($username, $password)) {
            $error_username = '* Wrong username or';
            $error_password = '* Wrong password';
            $display_modal_window = 'signin';
            include('startpage.php');
        } else {
            $_SESSION['username'] = $username;
            include('mainpage.php');
        }
        exit();
    }
} 

elseif ($_POST['page'] == 'MainPage' && isset($_POST['command'])) {
    
    // initializing data for creating a post
    if ($_POST['command'] == 'SubmitPost') {
        echo json_encode(getPosts());
        exit();
    } 

    // creating a post
    else if ($_POST['command'] == 'CreatePost') {
        if (insertPost($_POST['title'], $_POST['content'], $_SESSION['username'])) {
            echo 'post_created';
        } else {
            echo 'post_not_created';
        }
        exit();
    } 

    // retrieving data for editing a post
    else if ($_POST['command'] === 'GetPost') {
        $postId = $_POST['postId'];
        $posts = getPosts();
        $postData = null;
        foreach ($posts as $post) {
            if ($post[0] == $postId) {
                $postData = $post;
                break;
            }
        }

        if ($postData) {
            echo json_encode($postData); 
        } else {
            echo 'post_not_found'; 
        }
        exit();
    }

    // editing post
    else if ($_POST['command'] === 'EditPost') {
        $postId = $_POST['postId'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        if (editPost($postId, $title, $content)) {
            echo 'post_updated'; 
        } else {
            echo 'edit_failed';
        }
        exit();
    }

    // deleting post
    else if ($_POST['command'] === 'DeletePost') {
        $postId = $_POST['postId'];

        if (deletePost($postId)) {
            echo 'post_deleted';
        } else {
            echo 'delete_failed';
        }
        exit();
    }

    // upvoting post
    else if ($_POST['command'] === 'UpvotePost') {
        $postId = $_POST['postId'];
        $user = $_SESSION['username'];

        if (upvote($postId, $user)) {
            echo 'post_upvoted';
        } else {
            echo 'upvote_failed';
        }
        exit();
    }

    // downvoting post
    else if ($_POST['command'] === 'DownvotePost') {
        $postId = $_POST['postId'];
        $user = $_SESSION['username'];

        if (downvote($postId, $user)) {
            echo 'post_downvoted';
        } else {
            echo 'downvote_failed';
        }
        exit();
    }

    // creating a comment
    else if ($_POST['command'] == 'CreateComment') {
        $comment = $_POST['comment'];
        $post_id = $_POST['postId'];
        $user = $_SESSION['username'];
        
        if (insertComment($comment, $post_id, $user)) {
            echo 'comment_created';
        } else {
            echo 'comment_failed';
        }
        exit();
    }

    // editing post
    else if ($_POST['command'] === 'EditPost') {
        $postId = $_POST['postId'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        if (editPost($postId, $title, $content)) {
            echo 'post_updated'; 
        } else {
            echo 'edit_failed';
        }
        exit();
    }

    // changing profile (email and password)
    else if ($_POST['command'] === 'ChangeProfile') {
        $newEmail = $_POST['newEmail'];
        $newPassword = $_POST['newPassword'];
        $username = $_POST['username'];
        if (changeProfile($username, $newEmail, $newPassword)) {
            echo 'profile_changed';
        } else {
            echo 'profile_not_changed';
        }
        exit();
    }  
    
    // searching for posts based on search term
    else if ($_POST['command'] == 'SearchPosts') {
        $term = $_POST['search_term'];
        $posts = searchPosts($term);
        echo json_encode($posts);
        exit();
    }

    // logging out
    else if ($_POST['command'] == 'LogOut') {
        session_unset();
        session_destroy();
        $display_modal_window = 'none';
        include('startpage.php');
        exit();
    }

    // deleting account and posts
    else if ($_POST['command'] == 'DeleteUser') {
        $username = $_SESSION['username'];
        deleteUser($username);
        session_unset();
        session_destroy();
        exit();
    }    
}
?>