<?php
$display_modal_window = 'none';

if ($display_modal_window == 'signin' || !empty($error_username) || !empty($error_password)) {
    echo "<script>document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modal-login').style.display = 'block';
    });</script>";
    
    if (!empty($error_username)) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('error-username').innerHTML = '" . $error_username . "';
        });</script>";
    }
    
    if (!empty($error_password)) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('error-password').innerHTML = '" . $error_password . "';
        });</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Posting Forum Website</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        #layout-main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1,
        h2 {
            color: #333;
            text-align: center;
        }

        h2 {
            margin-top: 5px;
            margin-bottom: 60px;
        }

        .main-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 300px;
        }

        .main-button:hover {
            background-color: #0056b3;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .secondary-button {
            background-color: #6c757d;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100px;
            margin-right: 10px;
            margin-left: 2px;
        }

        .secondary-button:hover {
            background-color: #5a6268;
        }

        .submit-button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100px;
            margin-right: 2px;
        }

        .submit-button:hover {
            background-color: #218838;
        }

        .modal-window {
            width: 400px;
            border: 1px solid black;
            display: none;
            background-color: white;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        #blanket {
            display: none;
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 998;
            opacity: 0.5;
            background-color: grey;
        }

        .modal-label-input {
            display: block;
            margin-bottom: 10px;
            text-align: left;
        }

        .modal-input-field {
            width: calc(100% - 20px);
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>
</head>

<body style='margin:0'>

    <!-- Page Layout -->

    <div id='layout-main'>
        <br>
        <h1>Welcome to the Forum</h1>
        <br>
        <h2>Join our community and engage in discussions, share ideas, and connect with others</h2>
        <button id='menu-login' class='main-button'>Login</button>
        <br>
        <br>
        <button id='menu-signup' class='main-button'>Sign Up</button>
        <br>
    </div>

    <!-- Modal Windows -->

    <div id='modal-login' class='modal-window'>
        <h3 style='text-align:center'>Login to the Forum</h3>
        <br>
        <form method='post' action='controller.php'>
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='SignIn'>
            <label class='modal-label-input' for='input-login-username'>Username:</label>
            <input id='input-login-username' type='text' name='username' class='modal-input-field'>
            <span id='error-username' class='error-message'></span><br>
            <label class='modal-label-input' for='input-login-password'>Password:</label>
            <input id='input-login-password' type='password' name='password' class='modal-input-field'>
            <span id='error-password' class='error-message'></span><br>
            <div class="button-container">
                <button id="submit-modal-login" class="submit-button">Submit</button>
                <button id="cancel-modal-login" type="button" class="secondary-button">Cancel</button>
            </div>
        </form>
    </div>
    <div id='modal-signup' class='modal-window'>
        <h3 style='text-align:center'>Sign Up to the Forum</h3>
        <br>
        <form method='post' action='controller.php'>
            <input type='hidden' name='page' value='StartPage'>
            <input type='hidden' name='command' value='SignUp'>
            <label class='modal-label-input' for='input-signup-username'>Username:</label>
            <input id='input-signup-username' type='text' name='username' class='modal-input-field'><br>
            <label class='modal-label-input' for='input-signup-password'>Password:</label>
            <input id='input-signup-password' type='password' name='password' class='modal-input-field'><br>
            <label class='modal-label-input' for='input-signup-email'>Email:</label>
            <input id='input-signup-email' type='text' name='email' class='modal-input-field'></br>
            <div class="button-container">
                <button id="submit-modal-signup" class="submit-button">Submit</button>
                <button id="cancel-modal-signup" type="button" class="secondary-button">Cancel</button>
            </div>
        </form>
    </div>
    <div id='blanket'></div>

    <script>
        // Function to show the login modal
        document.getElementById("menu-login").addEventListener("click", function () {
            document.getElementById("blanket").style.display = "block";
            document.getElementById("modal-login").style.display = "block";
        });

        // Function to hide the login modal
        document.getElementById("cancel-modal-login").addEventListener("click", function () {
            document.getElementById("blanket").style.display = "none";
            document.getElementById("modal-login").style.display = "none";
        });

        // Function to show the sign-up modal
        document.getElementById("menu-signup").addEventListener("click", function () {
            document.getElementById("blanket").style.display = "block";
            document.getElementById("modal-signup").style.display = "block";
        });

        // Function to hide the sign-up modal
        document.getElementById("cancel-modal-signup").addEventListener("click", function () {
            document.getElementById("blanket").style.display = "none";
            document.getElementById("modal-signup").style.display = "none";
        });

        // Function to hide modals when clicking on the blanket overlay
        document.getElementById("blanket").addEventListener("click", function () {
            document.getElementById("blanket").style.display = "none";
            document.getElementById("modal-login").style.display = "none";
            document.getElementById("modal-signup").style.display = "none";
        });
    </script>

</body>

</html>
