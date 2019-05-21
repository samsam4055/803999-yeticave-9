<?php
$saved_email = $_POST['email'] ?? '';
$saved_password = $_POST['password'] ?? '';
?>
<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="all-lots.php?id=<?= $category['id']; ?>"><?= esc($category['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= $errors ? 'form--invalid' : ''; ?>" action="login.php" method="post">
        <h2>Вход</h2>
        <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : ""; ?>">
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" value="<?= htmlspecialchars($saved_email); ?>"
                   placeholder="Введите e-mail">
            <span class="form__error"><?= $errors['email']; ?></span>
        </div>
        <div class="form__item form__item--last <?= isset($errors['password']) ? "form__item--invalid" : ""; ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" value="<?= $saved_password; ?>"
                   placeholder="Введите пароль">
            <span class="form__error"><?= $errors['password']; ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
