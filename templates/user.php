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
    <form class="form container <?= isset($errors) ? 'form--invalid' : ''; ?>" action="user.php" method="post"
          enctype="multipart/form-data" autocomplete="off">
        <a class="text-link" href="my-lots.php"><h3>Смотреть мои лоты</h3></a>
		<h3>Мой аккаунт</h3>
        <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : ""; ?>">
            <label for="email">Мой E-mail</label>
            <input id="email" type="text" name="email" value="<?= htmlspecialchars($user[0]['email']); ?>" disabled
                   placeholder="Введите e-mail">
            <span class="form__error"><?= isset($errors['email']) ? $errors['email'] : ""; ?></span>
        </div>
        <div class="form__item <?= isset($errors['name']) ? "form__item--invalid" : ""; ?>">
            <label for="name">Имя <sup>*</sup></label>
            <input id="name" type="text" name="name" value="<?= htmlspecialchars($user[0]['name']); ?>"
                   placeholder="Введите имя">
            <span class="form__error"><?= isset($errors['name']) ? $errors['name'] : ""; ?></span>
        </div>
        <div class="form__item form__item--file <?= isset($errors['image']) ? 'form__item--invalid' : ''; ?>">
            <label>Аватар</label>
            <div class="form__input-file <?= isset($errors['image']) ? 'form__item--invalid' : ''; ?>">
                <input class="visually-hidden" type="file" id="lot-img" name="image" value="">
                <label for="lot-img">
                    Загрузить аватар
                </label>
                <span class="form__error"><?= isset($errors['image']) ? $errors['image'] : ''; ?></span>
            </div>
        </div>
        <div class="form__item <?= isset($errors['message']) ? "form__item--invalid" : ""; ?>">
            <label for="message">Контактные данные <sup>*</sup></label>
            <textarea id="message" name="message"
                      placeholder="Напишите как с вами связаться"><?= htmlspecialchars($user[0]['contact']); ?></textarea>
            <span class="form__error"><?= isset($errors['message']) ? $errors['message'] : ""; ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Поменять данные</button>
        <a class="text-link" href="index.php">Не менять данные</a>
    </form>
</main>
