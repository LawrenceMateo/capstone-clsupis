<!DOCTYPE html>
<html>
<head>
    <?php include '../partials/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="../../assets/css/login_register.css" />
    <title>Login</title>
  
</head>
    <body>
        <div class="container-fluid bg">
            <div class="row">
                <div class="col-md-4 col-sm-2 col-ms-12"></div>
                <div class="col-md-4 col-sm-2 col-ms-12 ">
                    <!-- FORM START -->
                    <form id="login-form" class="mdl-shadow--2dp form-container" onsubmit="return loginAccount()">
                        <h1 class="top-text">Login</h1>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="login-email" class="mdl-textfield__input" type="email" name="login_email" >
                            <label class="mdl-textfield__label" for="sample3">Email</label>
                        </div>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="login-password" class="mdl-textfield__input" type="password" name="login_password">
                            <label class="mdl-textfield__label" for="sample3">Password</label>
                        </div>
                        <div class="form-group">
                            <button id="login-submit" class="btn btn-success btn-block" type="submit">Login</button>
                        </div>
                        <div id="create-account" class="form-group">
                            <p>
                                <a style="" href="./register_form.php">Create an Account?</a>
                            </p>
                        </div>
                    </form> 
                    <!-- FORM END-->
                </div>                
            </div>
        </div>
    </body>
    <?php include '../../includes/scripts.php'; ?>
</html>