<!DOCTYPE html>
<html>
<head>
    <?php include '../partials/head.php'; ?>
    <link rel="stylesheet" type="text/css" href="../../assets/css/login_register.css" />
    <title>Register</title>
</head>
    <body>
        <div class="container-fluid bg">
            <div class="row">
                <div class="col-md-4 col-sm-2 col-ms-12"></div>
                <div class="col-md-4 col-sm-2 col-ms-12">
                    <!-- FORM START -->
                    <form id="reg-form" class=" bot-margin mdl-shadow--2dp form-container" onsubmit="return registerAccount()">
                        <h1 class="top-text">Register</h1>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="reg-firstname" class="reg-val mdl-textfield__input" type="text" name="reg_firstname">
                            <label class="mdl-textfield__label" for="sample3">First Name</label>
                        </div>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="reg-middlename" class="reg-val mdl-textfield__input" type="text" name="reg_middlename">
                            <label class="mdl-textfield__label" for="sample3">Middle Name</label>
                        </div>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="reg-lastname" class="reg-val mdl-textfield__input" type="text" name="reg_lastname">
                            <label class="mdl-textfield__label" for="sample3">Last Name</label>
                        </div>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select id="reg-gender" class="mdl-textfield__input">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="reg-contact-number" class="reg-val mdl-textfield__input" type="text" name="reg_contact_num">
                            <label class="mdl-textfield__label" for="sample3">Contact Number</label>
                        </div>                        
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="reg-email" class="reg-val mdl-textfield__input" type="email" name="reg_email" onblur="confirmEmail()">
                            <label class="mdl-textfield__label" for="sample3">Email</label>
                        </div>
                        <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input id="reg-username" class="reg-val mdl-textfield__input" type="text" name="reg_username" onblur="checkUsername()">
                            <label class="mdl-textfield__label" for="sample3">Username</label>
                        </div>
                        <div class="form-group">
                         
                                <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input id="reg-password" class="reg-val mdl-textfield__input" type="password" name="reg_password" >
                                    <label class="mdl-textfield__label" for="sample3">Password</label>
                                </div>
                                <div class="form-group mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input id="reg-con-password" class="reg-val mdl-textfield__input" type="password" name="reg_con_password" > 
                                    <label class="mdl-textfield__label" for="sample3">Confirm</label>       
                                </div>  
                            
                        </div>
                        <div class="form-group">
                            <button id="login-submit" class="btn btn-success btn-block" type="submit">Sign Up</button>
                        </div>
                        <div id="create-account" class="form-group">
                            <p>
                                <a href="login_form.php">Already have an Account?</a>
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