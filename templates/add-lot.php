<?php
$saved_name = $_POST['lot-name'] ?? '';
$saved_category = $_POST['category'] ?? '';
$saved_message = $_POST['message'] ?? '';
$saved_image = $_FILES['image']['name'] ?? '';
$saved_start_price = $_POST['lot-rate'] ?? '';
$saved_step = $_POST['lot-step'] ?? '';
$saved_date = $_POST['lot-date'] ?? '';
?>
<main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category) : ?>
            <li class="nav__item">
                <a href="all-lots.html"><?= esc($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <form class="form form--add-lot container <?=$errors ? 'form--invalid' : '';?>" action="add.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?=isset($errors['lot-name']) ? "form__item--invalid" : "";?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" value="<?=htmlspecialchars($saved_name);?>" placeholder="Введите наименование лота">
          <span class="form__error"><?=$errors['lot-name'];?></span>
        </div>
		<div class="form__item <?=isset($errors['category']) ? "form__item--invalid" : "";?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category" >
            <option value="-1" <?=!isset($errors['category']) ? "selected" : "";?>>Выберите категорию</option>
            <?php foreach ($categories as $category) : ?>
			<option value="<?=$category['id'];?>" <?php if ($category['id'] == $saved_category) echo "selected";?>><?= esc($category['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <span class="form__error"><?=$errors['category'];?></span>
        </div>
      </div>

	  <div class="form__item form__item--wide <?=isset($errors['message']) ? "form__item--invalid" : "";?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" maxlength="1000" placeholder="Напишите описание лота"><?=htmlspecialchars($saved_message);?></textarea>
        <span class="form__error"><?=$errors['message'];?></span>
      </div>
      <div class="form__item form__item--file <?=isset($errors['image']) ? 'form__item--invalid' : '';?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file <?=isset($errors['image']) ? 'form__item--invalid' : '';?>">
          <input class="visually-hidden" type="file" id="lot-img" name="image" value="">
          <label for="lot-img">
            <?=isset($errors['image']) ? 'Добавте файл' : 'Добавить';?>
          </label>
		  <span class="form__error"><?=isset($errors['image']) ? $errors['image'] : '';?></span>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?=isset($errors['lot-rate']) ? 'form__item--invalid' : '';?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" value="<?=htmlspecialchars($saved_start_price);?>" placeholder="0">
          <span class="form__error"><?=$errors['lot-rate'];?></span>
        </div>
        <div class="form__item form__item--small <?=isset($errors['lot-step']) ? 'form__item--invalid' : '';?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" value="<?=htmlspecialchars($saved_step);?>" placeholder="0">
          <span class="form__error"><?=$errors['lot-step'];?></span>
        </div>
        <div class="form__item <?=isset($errors['lot-date']) ? 'form__item--invalid' : '';?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date"  value="<?=htmlspecialchars($saved_date);?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД" required>
          <span class="form__error"><?=$errors['lot-date'];?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
