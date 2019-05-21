<?php
$saved_email = $_POST['email'] ?? '';
$saved_password = $_POST['password'] ?? '';
$saved_name = $_POST['name'] ?? '';
$saved_message = $_POST['message'] ?? '';
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
    <form class="form container <?= $errors ? 'form--invalid' : ''; ?>" action="sign-up.php" method="post"
          autocomplete="off">
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : ""; ?>">
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" value="<?= htmlspecialchars($saved_email); ?>"
                   placeholder="Введите e-mail">
            <span class="form__error"><?= $errors['email']; ?></span>
        </div>
        <div class="form__item <?= isset($errors['password']) ? "form__item--invalid" : ""; ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" value="<?= $saved_password; ?>"
                   placeholder="Введите пароль">
            <span class="form__error">Введите пароль</span>
        </div>
        <div class="form__item <?= isset($errors['name']) ? "form__item--invalid" : ""; ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" value="<?= htmlspecialchars($saved_name); ?>"
                   placeholder="Введите имя">
            <span class="form__error"><?= $errors['name']; ?></span>
        </div>
        <div class="form__item <?= isset($errors['message']) ? "form__item--invalid" : ""; ?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="message"
                      placeholder="Напишите как с вами связаться"><?= htmlspecialchars($saved_message); ?></textarea>
            <span class="form__error"><?= $errors['message']; ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>
