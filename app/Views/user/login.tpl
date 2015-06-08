

<form class="form-signin" method="post" action="index.php?controller=user&action=login">
    <h2 class="form-signin-heading">sign in now</h2>
    <div class="login-wrap">
        <input type="text" name="username" id="username" class="form-control" placeholder="User Name" autofocus>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">

        <button class="btn btn-lg btn-login btn-block" name="submitSigin" id="submitSigin" type="submit">Sign in</button>
        {if !empty($message)}
            <div style="color:red">{$message}</div>
        {/if}

    </div>

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Forgot Password ?</h4>
                </div>
                <div class="modal-body">
                    <p>Enter your e-mail address below to reset your password.</p>
                    <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                    <button class="btn btn-success" type="button">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->

</form>