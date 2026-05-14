<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - ADRA</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="login-container">

    <!-- FAIXAS -->
    <div class="stripe stripe-top-1"></div>
    <div class="stripe stripe-top-2"></div>

    <div class="stripe stripe-bottom-1"></div>
    <div class="stripe stripe-bottom-2"></div>

    <!-- LOGIN BOX -->
    <div class="login-box">

        <div class="logo">ADRA</div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Entrar
            </button>

            <a href="{{ route('register') }}">
                <button type="button" class="btn btn-light">
                    Cadastro
                </button>
            </a>

            <a href="#">
                <button type="button" class="btn btn-light">
                    Esqueceu a senha?
                </button>
            </a>

        </form>

    </div>

</div>

</body>
</html>