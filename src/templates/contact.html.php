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
    <h1>Contact us!</h1>
</header>

<main>
    <?php if ($success == true): ?>
        <div class="success">Thank you for contacting us, we will respond as soon as possible!</div>
    <?php endif ?>
    <form method="post">
        <ul>
            <li <?php if (isset($errors['email'])): ?>class="error"<?php endif ?>>
                <label for="contact_email">E-mail</label>
                <input
                    type="email"
                    name="contact[email]"
                    id="contact_email"
                    placeholder="john@doe.com"
                    value="<?php echo ($data['email'] ?? '') ?>"
                >
                <?php if (isset($errors['email'])): ?>
                    <p><?php echo $errors['email'] ?></p>
                <?php endif ?>
            </li>
            <li <?php if (isset($errors['message'])): ?>class="error"<?php endif ?>>
                <label for="contact_message">Your message</label>
                <textarea
                    name="contact[message]"
                    id="contact_message"
                    placeholder="Write your messege here..."
                ><?php echo ($data['message'] ?? '') ?></textarea>
                <?php if (isset($errors['message'])): ?>
                    <p><?php echo $errors['message'] ?></p>
                <?php endif ?>
            </li>
            <li>
                <button type="submit">Send!</button>
            </li>
        </ul>
    </form>
</main>

</body>
</html>
