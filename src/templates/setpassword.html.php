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
    <h1>Ustaw Nowe Hasło </h1>
</header>

<main>
    <?php if ($success == true): ?>
    <?php endif ?>
    <form method="post">
        <ul>
            <li <?php if (isset($errors['pass'])): ?>class="error"<?php endif ?>>
                <label for="check_email">Wpisz Hasło </label>
                <input
                    type="password"
                    name="password[pass]"
                    id="password"
                    placeholder="hasło"
                >
                <?php if (isset($errors['pass'])): ?>
                    <p><?php echo $errors['pass'] ?></p>
                <?php endif ?>
            </li>
            <li <?php if (isset($errors['repeatpass'])): ?>class="error"<?php endif ?>>
                <label for="check_email">Powtórz Hasło </label>
                <input
                    type="password"
                    name="password[repeatpass]"
                    id="rpassword"
                    placeholder="powtórz hasło"
                >
                <?php if (isset($errors['repeatpass'])): ?>
                    <p><?php echo $errors['repeatpass'] ?></p>
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
