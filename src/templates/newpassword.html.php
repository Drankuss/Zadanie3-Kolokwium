<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title ?></title>
    <style>
        .error { color: #f00; }
        .success { color: #090 }
    </style>
</head>
<body>

<header>
    <h1>Wpisz Swój Email</h1>
</header>

<main>
    <?php if ($success == true): ?>
        <div class="success">Sprawdź e-mail w celu zresetowania hasła</div>
    <?php endif ?>
    <form method="post">
        <ul>
            <li <?php if (isset($errors['email'])): ?>class="error"<?php endif ?>>
                <label for="check_email">E-mail: </label>
                <input
                    type="email"
                    name="check[email]"
                    id="email"
                    placeholder="panda@czy.com"
                    value="<?php echo ($data['email'] ?? '') ?>"
                >
                <?php if (isset($errors['email'])): ?>
                    <p><?php echo $errors['email'] ?></p>
                <?php endif ?>
                </li>
            <li>
                <button type="submit">Wyślij</button>
            </li>
        </ul>
    </form>
</main>

</body>
</html>
