<!doctype html>
<html>
<head>
    <title>Forum Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .navbar {
            background-color: #007bff;
            padding: 18px;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: white;
        }

        .search-bar {
            width: 250px;
            margin-right: 10px;
        }

        .nav-link {
            margin-top: 20px;
            font-size: 21px;
            margin-bottom: 10px;
        }

        .post-container {
            padding: 20px;
        }

        .post {
            position: relative;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .vote-counts {
            position: absolute;
            top: 10px; 
            right: 10px; 
            font-size: 14px;
            color: #666;
        }

        .upvote-count,
        .downvote-count {
            margin-right: 1px;
        }

        .vote-border {
            margin: 6px;
        }

        .edit-post-btn {
            margin-right: 5px;
        }

        .upvote-btn {
            margin-right: 5px;
        }

        .nav-link {
            margin-bottom: 10px;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .nav-link:hover {
            background-color: #ccc;
        }

        .nav-link.active,
        .nav-link:active {
            background-color: #007bff;
            color: white;
        }

        .right-column {
            border-left: 2px solid #ccc;
            height: 100%;
        }

        .comment {
            border-top: 1px solid #ccc;
            color: #666;
            font-size: 14px; 
            margin-top: 10px;
        }

        .comment-section {
            display: flex;
            align-items: center;
            justify-content: flex-end; 
            margin-top: 10px; 
        }

        .comment-section textarea {
            flex: 1;
            margin-right: 10px;
        }

        .comment-section button {
            margin-left: 10px;
        }

        .no-results {
            text-align: center;
            font-size: 24px;
        }
        </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <form id="search-form" class="d-flex me-auto align-items-center">
                <input id="search-input" class="form-control me-2 search-bar" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light search-btn" type="submit">Search</button>
            </form>
            <button id="create-post-btn" class="btn btn-outline-light">Create Post</button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-2">
                <div class="nav flex-column nav-pills" aria-orientation="vertical">
                    <a class="nav-link" aria-current="page" href="#" id="home-link">Home</a>
                    <a class="nav-link" href="#" id="profile-link">Profile</a>
                    <a class="nav-link" href="#" id="logout-link">Logout</a>
                    <a class="nav-link delete-account" href="#" id="delete-link">Delete Account</a>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-10 right-column">
                <div class="post-container" id="postContainer">
                    <!-- Posts loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for creating a post -->
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">Create a Post</h5>
                </div>
                <div class="modal-body">
                    <form id="createPostForm" method="post" action="controller.php">
                        <input type="hidden" name="page" value="MainPage"> 
                        <input type="hidden" name="command" value="SubmitPost">
                        <div class="mb-3">
                            <label for="postTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="postTitle" name="title"> 
                        </div>
                        <div class="mb-3">
                            <label for="postContent" class="form-label">Content</label>
                            <textarea class="form-control" id="postContent" rows="3" name="content"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="postBtn" name="submit">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing a post -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                </div>
                <div class="modal-body">
                    <form id="editPostForm" method="post" action="controller.php"> 
                        <input type="hidden" name="page" value="MainPage"> 
                        <input type="hidden" name="command" value="EditPost"> 
                        <input type="hidden" id="editPostId" name="postId">
                        <div class="mb-3">
                            <label for="editPostTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editPostTitle" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="editPostContent" class="form-label">Content</label>
                            <textarea class="form-control" id="editPostContent" rows="3" name="content"></textarea> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
        </div>
        <div class="modal-body">
            <p>Username: <span id="profile-username"></span></p>
            <form id="editProfileForm">
            <div class="form-group">
                <label for="newEmailInput">New Email:</label>
                <input type="email" class="form-control" id="newEmailInput" placeholder="Enter new email">
            </div>
            <div class="form-group">
                <label for="newPasswordInput">New Password:</label>
                <input type="password" class="form-control" id="newPasswordInput" placeholder="Enter new password">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <script>
    $(document).ready(function() {

        // home link onclick
        $('#home-link').on('click', function(event) {
            loadPosts();
        });

        // profile link onclick
        $('#profile-link').on('click', function(event) {
            event.preventDefault();
            var username = '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?>';
            
            if (username) {
                $('#profileModal').modal('show');
                $('#profile-username').text(username);
            } else {
                alert('User profile not found.');
            }
        });


        // change profile form submission
        $('#editProfileForm').submit(function(event) {
            event.preventDefault();
            var newEmail = $('#newEmailInput').val();
            var newPassword = $('#newPasswordInput').val();
            var username = '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?>';

            if (newEmail.trim() === '' || newPassword.trim() === '') {
                alert('Please fill up both email and password fields.');
                return;
            }
            
            $.post('controller.php', {
                page: 'MainPage',
                command: 'ChangeProfile',
                username: username,
                newEmail: newEmail,
                newPassword: newPassword
            }, function(response) {                
                if (response === 'profile_changed') {
                    $('#newEmailInput').val('');
                    $('#newPasswordInput').val('');
                    $('#profileModal').modal('hide');
                } else {
                    alert('Failed to change profile. Please try again.');
                }
            });
        });

        
        function loadPosts() {
            $.post('controller.php', {
                page: 'MainPage',
                command: 'SubmitPost'
            }, function(response) {
                var postsArr = JSON.parse(response);
                $('#postContainer').empty();

                postsArr.forEach(function(postInfo) {
                    var postId = postInfo[0];
                    var postTitle = postInfo[1];
                    var postContent = postInfo[2];
                    var postUsername = postInfo[3];
                    var upvotes = postInfo[5];
                    var downvotes = postInfo[6]; 
                    var comments = postInfo[7]; 

                    var isOwner = postUsername === '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>';
                    var postHTML = '<div class="post" data-post-id="' + postId + '">' +
                                        '<h3>' + postTitle + '</h3>' +
                                        '<p>' + postContent + '</p>' +
                                        '<div class="vote-counts">' +
                                            '<span class="upvote-count">' + upvotes + '</span> Upvotes ' + 
                                            '<span class="vote-border">  |  </span>' + 
                                            '<span class="downvote-count">' + downvotes + '</span> Downvotes' + 
                                        '</div>';

                    if (isOwner) {
                        postHTML += '<div class="d-flex justify-content-end">' +
                                        '<button class="btn btn-primary edit-post-btn">Edit</button>' +
                                        '<button class="btn btn-danger delete-post-btn">Delete</button>' +
                                    '</div>';
                    } else {
                        postHTML += '<div class="d-flex justify-content-between align-items-center">' +
                                        '<div class="vote-counts">' +
                                            '<span class="upvote-count">' + upvotes + '</span> Upvotes ' +
                                            '<span class="vote-border">  |  </span>' +
                                            '<span class="downvote-count">' + downvotes + '</span> Downvotes' +
                                        '</div>' +
                                        '<div class="comment-section">' +
                                            '<textarea class="form-control comment-text" rows="1" placeholder="Write a comment"></textarea>' +
                                            '<button type="submit" class="btn btn-primary btn-sm comment-btn">Submit Comment</button>' +
                                        '</div>' +
                                        '<div>' +
                                            '<button class="btn btn-success upvote-btn">Upvote</button>' +
                                            '<button class="btn btn-danger downvote-btn">Downvote</button>' +
                                        '</div>' +
                                    '</div>';
                    }

                    if (!Array.isArray(comments)) {
                        if (comments === null) {
                            comments = [];
                        } else {
                            comments = [comments];
                        }
                    }

                    if (comments.length > 0) {
                        postHTML += '<div class="comments-container">';
                        comments.forEach(function(comment) {
                            postHTML += '<div class="comment">Comments:' + comment + '</div>';
                        });
                        postHTML += '</div>';
                    } else {
                        postHTML += '<div class="comments-container">';
                        postHTML += '<div class="comment">0 comments</div>';
                        postHTML += '</div>';
                    }

                    postHTML += '</div>';
                    $('#postContainer').append(postHTML);
                });
            });
        }

        // load posts in database table onto feed
        loadPosts();

        // create post form submission
        $('#createPostForm').submit(function(event) {
            event.preventDefault(); 
            var title = $('#postTitle').val();
            var content = $('#postContent').val();

            if (title.trim() !== '' && content.trim() !== '') {
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'CreatePost', 
                    title: title,
                    content: content
                }, function(response) {
                    if (response.trim() === 'post_created') {
                        $('#postTitle').val('');
                        $('#postContent').val('');
                        loadPosts();
                        $('#createPostModal').modal('hide');
                    } else {
                        alert('Failed to create the post. Please try again.');
                    }
                });
            } else {
                alert('Please enter both a title and content for your post.');
            }
        });

        // edit post button onclick
        $(document).on('click', '.edit-post-btn', function() {
            var postId = $(this).closest('.post').attr('data-post-id');
            
            $.post('controller.php', {
                page: 'MainPage',
                command: 'GetPost',
                postId: postId 
            }, function(response) {
                if (response.trim() === 'post_not_found') {
                    alert('Failed to retrieve the post data. Please try again.');
                    return;
                }

                var postData = JSON.parse(response);
                var postId = postData[0];
                var postTitle = postData[1];
                var postContent = postData[2];
                var postUsername = postData[3];

                var isOwner = postUsername === '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>';

                if (isOwner) {
                    $('#editPostId').val(postId);
                    $('#editPostTitle').val(postTitle);
                    $('#editPostContent').val(postContent);
                    $('#editPostModal').modal('show');
                } else {
                    alert('You do not have permission to edit this post.');
                }
            });
        });

        // edit post form submission
        $('#editPostForm').submit(function(event) {
            event.preventDefault(); 
            var postId = $('#editPostId').val(); 
            var title = $('#editPostTitle').val();
            var content = $('#editPostContent').val();

            $.post('controller.php', {
                page: 'MainPage',
                command: 'EditPost', 
                postId: postId,
                title: title,
                content: content
            }, function(response) {
                if (response.trim() === 'post_updated') {
                    loadPosts();
                    $('#editPostModal').modal('hide');
                } else {
                    alert('Failed to edit the post. Please try again.');
                }
            });
        });

        // delete post button onclick
        $(document).on('click', '.delete-post-btn', function() {
            var postId = $(this).closest('.post').attr('data-post-id');
            if (confirm('Are you sure you want to delete this post?')) {
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'DeletePost', 
                    postId: postId
                }, function(response) {
                    if (response.trim() === 'post_deleted') {
                        loadPosts();
                    } else {
                        //alert('Failed to delete the post. Please try again.');
                        loadPosts();
                    }
                });
            }
        });

        // upvoting onclick
        $(document).on('click', '.upvote-btn', function() {
            var postId = $(this).closest('.post').attr('data-post-id');
            $.post('controller.php', {
                page: 'MainPage',
                command: 'UpvotePost',
                postId: postId
            }, function(response) {
                if (response.trim() === 'upvote_success') {
                    loadPosts(); 
                } else {
                    //alert('Failed to upvote the post. Please try again.');
                    loadPosts();
                }
            });
        });

        // downvoting onclick
        $(document).on('click', '.downvote-btn', function() {
            var postId = $(this).closest('.post').attr('data-post-id');
            $.post('controller.php', {
                page: 'MainPage',
                command: 'DownvotePost',
                postId: postId
            }, function(response) {
                if (response.trim() === 'downvote_success') {
                    loadPosts(); 
                } else {
                    //alert('Failed to downvote the post. Please try again.');
                    loadPosts();
                }
            });
        });

        // comment button onclick
        $(document).on('click', '.comment-btn', function() {
            var postId = $(this).closest('.post').attr('data-post-id');
            var commentText = $(this).closest('.comment-section').find('.comment-text').val();
            
            if (commentText.trim() !== '') {
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'CreateComment',
                    postId: postId,
                    comment: commentText
                }, function(response) {
                    if (response.trim() === 'comment_created') {
                        loadPosts();
                    } else {
                        alert('Failed to submit comment. Please try again.');
                    }
                });
            } else {
                alert('Please enter a comment before submitting.');
            }
        });

        // search form submission
        $('#search-form').submit(function(event) {
            event.preventDefault(); 
            var searchTerm = $('#search-input').val().trim(); 
            if (searchTerm !== '') {
                searchPosts(searchTerm);
            } else {
                loadPosts();
            }
        });

        function searchPosts(term) {
            $.post('controller.php', {
                page: 'MainPage',
                command: 'SearchPosts',
                search_term: term
            }, function(response) {
                var postsArr = JSON.parse(response);
                $('#postContainer').empty();

                if (postsArr.length === 0) {
                    $('#postContainer').append('<div class="no-results">NO RESULTS</div>');
                } else {
                    postsArr.forEach(function(postInfo) {
                        var postId = postInfo.Id;
                        var postTitle = postInfo.Title;
                        var postContent = postInfo.Content;
                        var postUsername = postInfo.Username;
                        var upvotes = postInfo.Upvotes;
                        var downvotes = postInfo.Downvotes;
                        var comments = postInfo.Comments;

                        var isOwner = postUsername === '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>';
                        var postHTML = '<div class="post" data-post-id="' + postId + '">' +
                                            '<h3>' + postTitle + '</h3>' +
                                            '<p>' + postContent + '</p>' +
                                            '<div class="vote-counts">' +
                                                '<span class="upvote-count">' + upvotes + '</span> Upvotes ' + 
                                                '<span class="vote-border">  |  </span>' + 
                                                '<span class="downvote-count">' + downvotes + '</span> Downvotes' + 
                                            '</div>';

                        if (isOwner) {
                            postHTML += '<div class="d-flex justify-content-end">' +
                                            '<button class="btn btn-primary edit-post-btn">Edit</button>' +
                                            '<button class="btn btn-danger delete-post-btn">Delete</button>' +
                                        '</div>';
                        } else {
                            postHTML += '<div class="d-flex justify-content-between align-items-center">' +
                                            '<div class="vote-counts">' +
                                                '<span class="upvote-count">' + upvotes + '</span> Upvotes ' +
                                                '<span class="vote-border">  |  </span>' +
                                                '<span class="downvote-count">' + downvotes + '</span> Downvotes' +
                                            '</div>' +
                                            '<div class="comment-section">' +
                                                '<textarea class="form-control comment-text" rows="1" placeholder="Write a comment"></textarea>' +
                                                '<button type="submit" class="btn btn-primary btn-sm comment-btn">Submit Comment</button>' +
                                            '</div>' +
                                            '<div>' +
                                                '<button class="btn btn-success upvote-btn">Upvote</button>' +
                                                '<button class="btn btn-danger downvote-btn">Downvote</button>' +
                                            '</div>' +
                                        '</div>';
                        }

                        if (!Array.isArray(comments)) {
                            if (comments === null) {
                                comments = [];
                            } else {
                                comments = [comments];
                            }
                        }

                        if (comments.length > 0) {
                            postHTML += '<div class="comments-container">';
                            comments.forEach(function(comment) {
                                postHTML += '<div class="comment">Comments:' + comment + '</div>';
                            });
                            postHTML += '</div>';
                        } else {
                            postHTML += '<div class="comments-container">';
                            postHTML += '<div class="comment">0 comments</div>';
                            postHTML += '</div>';
                        }

                        postHTML += '</div>';
                        $('#postContainer').append(postHTML);
                    });
                }
            });
        }

        // create post button onclick
        $('#create-post-btn').click(function() {
            $('#createPostModal').modal('show');
        });

        // hide onclick for create post
        $('#createPostModal').on('hide.bs.modal', function() {
            $('#postTitle, #postContent').val('');
        });

        // hide onclick for edit post
        $('#editPostModal').on('hide.bs.modal', function() {
            $('#editPostTitle, #editPostContent').val('');
        });

        // logout link onclick
        $('#logout-link').click(function(event) {
            event.preventDefault();
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'LogOut'
                }, function(response) {
                    window.location.href = 'startpage.php'; 
                });
            }
        });

        // delete account link onclick
        $('#delete-link').click(function(event) {
            var username = '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?>';
            event.preventDefault();
            if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                var username = $('#username').val();
                $.post('controller.php', {
                    page: 'MainPage',
                    command: 'DeleteUser',
                    username: username
                }, function(response) {
                    if (response === 'success') {
                        window.location.href = 'startpage.php'; 
                    } else {
                        //alert('Failed to delete account. Please try again.');
                        window.location.href = 'startpage.php'; 
                    }
                });
            }
        });
    });
</script>

</body>
</html>