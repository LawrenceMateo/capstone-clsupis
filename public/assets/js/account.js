const registerAccount = () => {
    
    var firstname = $('#reg-firstname').val();
    var middlename = $('#reg-middlename').val();
    var lastname = $('#reg-lastname').val();
    var gender = $('#reg-gender').val();
    var email = $('#reg-email').val();
    var contact_num = $('#reg-contact-number').val();
    var username = $('#reg-username').val();
    var password = $('#reg-password').val();
    var con_password = $('#reg-con-password').val();

    if(password != con_password){
        notifyUser( `fa fa-window-close`, `Passwords do not match.`, `danger` );
        return false;
    }

    $.ajax({
        type : 'POST',
        url : '../../views/php/register.php',
        async : true,
        crossDomain: true,
        dataType: 'JSON',
        data : {'reg_firstname':toTitleCase(firstname), 'reg_middlename':toTitleCase(middlename), 'reg_lastname':toTitleCase(lastname), 'reg_gender':gender, 'reg_email':email, 'reg_contact_num':contact_num, 'reg_username':username, 'reg_password':password, 'reg_con_password':con_password},
        success : function(response){

            if(response.error === true){
                if( Array.isArray( (response.data.message) ) ) {
                    var messagesHTML = ``;

                    messagesHTML += `<ul>`;
                    (response.data.message).forEach( ( message ) => {
                        messagesHTML += `<li>${message}</li>`;
                    } );
                    messagesHTML += `</ul>`;
                    
                    notifyUser( `fa fa-window-close`, `${messagesHTML}`, `danger` );
                } else {
                    notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                }

            } else {
                console.log(response.data.message);
                notifyUser( `fa fa-check`, `Account registration is successful.`, `success` );
                setTimeout(function(){
                    window.location.href = "../../views/pages/login_form.php";             
                }, 1000);
            }
        },
        fail : function(response){

            if( response.error ) {
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
            } else {
                notifyUser( `fa fa-window-close`, `Something went wrong. Please try again later.`, `danger` );
            }
        }
    });

    return false;
 
}

const confirmEmail = () => {

    var email = $('#reg-email').val();

    if (email.value === ''){
        return false;
    }

    $.ajax({
        type : 'POST',
        url : '../../views/php/checkEmail.php',
        async : true,
        crossDomain : true,
        dataType: 'JSON',
        data : {'email':email},
        success : function(response){

            if(response.error){
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                $('#reg-email').val('');
            } else {
                if( response.data.isValidEmail ) {
                    // notifyUser( `fa fa-check`, `Email is valid.`, `success` );                
                } else {
                    notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                    $('#reg-email').val('');
                }
            }

        },
        fail : function(response){

            if(response.error){
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                $('#reg-email').val('');
            } else {
                notifyUser( `fa fa-window-close`, `Something went wrong. Please try again later.`, `danger` );
                $('#reg-email').val('');
            }
        }

    });

    return false;

}

const checkUsername = () => {

    var username = $('#reg-username').val();

    if( username.value === "" ) {
        return false;
    }

    $.ajax({
        type : 'POST',
        url : '../../views/php/checkUsername.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'username':username},
        success : function(response){

            if(response.error){
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                username.value = null;
            } else {
                if( response.data.isValidUsername ) {
                    // notifyUser( `fa fa-check`, `Username is valid.`, `success` );                
                } else {
                    notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                    $('#reg-username').val('');
                }
            }

        },
        fail : function(response){

            if(response.error){
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                $('#reg-username').val('');
            } else {
                notifyUser( `fa fa-window-close`, `Something went wrong. Please try again later.`, `danger` );
                $('#reg-username').val('');
            }
        }

    });

    return false;

}

const loginAccount = () => {

    var username = $('#login-email').val();
    var password = $('#login-password').val();

    $.ajax({

        type : 'POST',
        url : '../../views/php/loginAccount.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'login_email':username, 'login_password':password},
        success : function(response){

            if( response.error ) {
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
            } else {
                var notify = $.notify(
                    `Logging in...`,
                    {
                        type: `success`,
                        allow_dismiss: false,
                        showProgressBar: true
                    }
                );

                setTimeout(function(){
                    notify.update( `message`, response.data.message );           
                }, 1500);
                
                setTimeout(function(){
                    window.location.href = "../../views/pages/home.php";  
                }, 1000);
            }
        },
        fail : function(response){

            if(response.error){
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
            } else {
                notifyUser( `fa fa-window-close`, `Something went wrong. Please try again later.`, `danger` );
            }
        }

    });

    return false;

}

const logoutAccount = () => {
    window.location.href = "../../views/php/logoutAccount.php";
};
