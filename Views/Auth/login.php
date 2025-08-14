<!--== #HEADER ==-->
<?php adminHeader($data); ?>
<div class="sidenav">
    <div class="login-main-text">
        <h2>Bienvenido a<br>DBtracker</h2>
        <p>¡Es nuestro placer tenerte aquí!.</p>
    </div>


</div>
<div class="main">
    <div class="col-md-6 col-sm-12">
        <div class="login-form">
            <form class="form-data" data-destination="auth" calling-method="setLogin" data-type="json">
                <div class="form-group">
                    <label>Usuario o correo</label>
                    <input name="userEmail" id="userEmail" type="text" class="form-control form-control-db" placeholder="Usuario o correo">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input name="userPassword" id="userPassword" type="password" class="form-control form-control-db" placeholder="Contraseña">
                </div>
                <div class="btn-actions-login">
                    <div class="btn-login">
                        <button id="send-login" type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </div>
                    <div class="btn-help">
                        <p class="mt-2">
                            <a href="forgot-password.html">Olvidé mi contraseña</a>
                        </p>                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .main-head{
        height: 150px;
        background: #FFF;

    }

    .sidenav {
        height: 100%;
        background: rgb(3,7,18);
        background: linear-gradient(90deg, rgba(3,7,18,1) 0%, rgba(7,30,63,1) 76%);
        overflow-x: hidden;
        display: flex;
        align-items: center;
    }


    .main {
        padding: 0px 10px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
    }

    @media screen and (max-width: 450px) {
        .login-form{
            margin-top: 10%;
        }

        .register-form{
            margin-top: 10%;
        }
    }

    @media screen and (min-width: 768px){
        .main{
            margin-left: 40%;
        }

        .sidenav{
            width: 40%;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
        }

        .login-form{
            margin-top: 80%;
        }

        .register-form{
            margin-top: 20%;
        }
    }


    .login-main-text{
        padding: 60px;
        color: #fff;
    }

    .login-main-text h2{
        font-weight: 300;
    }

    .btn-black{
        background-color: #000 !important;
        color: #fff;
    }
</style>
<!-- Section: Design Block -->
<!-- Section: Design Block -->
<!-- /.login-box -->
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>