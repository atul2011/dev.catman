<?php
/**
 * @var QuarkView|LoginView $this
 */
use Quark\QuarkView;
use ViewModels\Admin\User\LoginView;
?>
<html>
<head>
<?php	echo $this->Resources();	?>
</head>
<body>
<div class="quark-presence-screen" id="content-screen">
    <form action="/admin/user/login" onsubmit="return ceckLogin();" method="POST">
        <div class="quark-presence-column center" id="content-half">
            <div class=" quark-presence-container content-items" id="title">
                <br/>
                Login
            </div>
            <br/>
            <div class="fields quark-presence-container body" id="login">
                <br/>
                <div class=" quark-presence-column login-form ">
                    <div class="quark-presence-container  form-titles content-items">
                        Login
                    </div>
                </div>
                <div class=" quark-presence-column login-form ">
                    <div class="quark-presence-container content-items">
                        <input type="text" class="quark-input input-fields" id="input-login" name="login"
                               placeholder="please enter your login"/>
                    </div>
                </div>
                <div class=" quark-presence-column login-form ">
                    <div class="quark-presence-container form-images content-items">
                        <img class="error-image" id="login-error-img" src="/static/Admin/images/error_mark.png"/>
                    </div>
                </div>
            </div>
            <br/>
            <div class="fields quark-presence-container errors-items" id="login-error">
                <span class="errors" id="login-error"></span>
            </div>
            <br/>
            <div class="fields quark-presence-container body " id="password">
                <br/>
                <div class=" quark-presence-column password-form ">
                    <div class="quark-presence-container form-titles content-items">
                        Password
                    </div>
                </div>
                <div class=" quark-presence-column password-form ">
                    <div class="quark-presence-container content-items">
                        <input type="password" class="quark-input input-fields" id="input-password" name="pass"
                               placeholder="please enter your password"/>
                    </div>
                </div>
                <div class=" quark-presence-column password-form ">
                    <div class="quark-presence-container form-images content-items">
                        <img class="error-image" id="password-error-img" src="/static/Admin/images/error_mark.png"/>
                    </div>
                </div>
            </div>
            <br/>
            <div class="fields quark-presence-container errors-items">
                <span class="errors" id="password-error"></span>
            </div>
            <br/>
            <div class="quark-presence-container content-items body" id="button-div">
                <br />
                <button type="submit" id="submit-button" class="quark-button">Login</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>