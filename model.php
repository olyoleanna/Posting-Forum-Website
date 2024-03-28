<?php
    $conn = mysqli_connect('localhost', 'testuser', 'testpassword', 'testdatabase');

    function isUsernameExists($username) {
        global $conn;
        $sql = "SELECT * FROM Users WHERE Username = '$username'";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result) > 0;
    }

    function insertUser($u, $p, $email) {
        global $conn;
        $current_date = date("Ymd");  
        $sql= "insert into Users values (NULL, '$u', '$p', '$email', $current_date)";
        mysqli_query($conn, $sql);
        $r = mysqli_query($conn, $sql);
        return $r;
    }    

    function isValidCredentials($username, $password) {
        global $conn;
        $sql = "SELECT * FROM Users WHERE Username = '$username' AND Password = '$password'";
        $result = mysqli_query($conn, $sql);
        return mysqli_num_rows($result) > 0;
    }
    
    function insertPost($title, $content, $user) {
        global $conn;
        $time = date('Y/m/d H:i:s');
        $sql = "INSERT INTO Posts VALUES (NULL, '$title', '$content', '$user', '$time', 0, 0, NULL)";
        $r = mysqli_query($conn, $sql);
        return $r;
    }

    function getPosts() {
        global $conn;
        $sql = "SELECT * FROM Posts ORDER BY Time DESC";
        $result = mysqli_query($conn, $sql);
        $array = [];
        while ($row = mysqli_fetch_assoc($result))
            $array[] = [$row['Id'], $row['Title'], $row['Content'], $row['Username'], $row['Time'], $row['Upvotes'], $row['Downvotes'], $row['Comments']];
        return $array;
    }

    function insertComment($comment, $post_id, $user) {
        global $conn;
        $comment = mysqli_real_escape_string($conn, $comment);
        $post_id = mysqli_real_escape_string($conn, $post_id);
        $user = mysqli_real_escape_string($conn, $user);
    
        $existing_comments = getComments($post_id);
        
        $all_comments = $existing_comments . "<br>" . $user . ": " . $comment;
    
        $sql = "UPDATE Posts SET Comments = '$all_comments' WHERE Id = '$post_id'";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
    
    function getComments($post_id) {
        global $conn;
        $sql = "SELECT Comments FROM Posts WHERE Id = '$post_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['Comments'];
    }    

    function upvote($post_id, $user) {
        global $conn;
        $sql = "UPDATE Posts SET Upvotes = Upvotes + 1 WHERE Id = '$post_id'";
        $r = mysqli_query($conn, $sql);
        return $r;
    }
    
    function downvote($post_id, $user) {
        global $conn;
        $sql = "UPDATE Posts SET Downvotes = Downvotes + 1 WHERE Id = '$post_id'";
        $r = mysqli_query($conn, $sql);
        return $r;
    }
    

    function editPost($postId, $title, $content) {
        global $conn;
        $sql = "UPDATE Posts SET Title = '$title', Content = '$content' WHERE Id = '$postId'";
        $result = mysqli_query($conn, $sql);
        return $result; 
    }    

    function deletePost($id) {
        global $conn;
        $sql = "DELETE FROM Posts WHERE Id = '$id'";
        mysqli_query($conn, $sql);
    }

    function searchPosts($term) {
        global $conn;
        $sql = "SELECT * FROM Posts WHERE Content LIKE '%$term%'";
        $result = mysqli_query($conn, $sql);
        $list =[];
        while($row = mysqli_fetch_assoc($result))
            $list[] = $row;
        return $list;
    }

    function changeProfile($username, $newEmail, $newPassword) {
        global $conn;
        $sql = "UPDATE Users SET Email = '$newEmail', Password = '$newPassword' WHERE Username = '$username'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }    

    function deleteUser($username) {
        global $conn;
    
        $sqlDeletePosts = "DELETE FROM Posts WHERE Username = '$username'";
        mysqli_query($conn, $sqlDeletePosts);
    
        $sqlDeleteUser = "DELETE FROM Users WHERE Username = '$username'";
        mysqli_query($conn, $sqlDeleteUser);
    }
    
?>
