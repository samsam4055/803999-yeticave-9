<main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category) : ?>
            <li class="nav__item">
                <a href="all-lots.php?id=<?=$category['id'];?>"><?= esc($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <section class="lot-item container">
	  <h2><?= esc($lot['name']); ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= $lot['img_url']; ?>" width="730" height="548" alt="Сноуборд">
          </div>
          <p class="lot-item__category">Категория: <span><?= esc($lot['category']); ?></span></p>
          <p class="lot-item__description"><?= esc($lot['description']); ?></p>
        </div>
        <div class="lot-item__right">
           <?php if($is_auth): ?>
          <div class="lot-item__state">
            <div class="lot-item__timer timer <?= add_time_class($lot['end_at']); ?>">
               <?= get_lot_timer($lot['end_at']); ?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?= format_price($lot['price']); ?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?= format_price($lot['new_price']); ?> р</span>
              </div>
            </div>
            <form class="lot-item__form" action="lot.php" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item <?=isset($errors['cost']) ? "form__item--invalid" : "";?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= format_price($lot['new_price']); ?>">
				 <input type="hidden" name="id" value="<?=$lot['id'];?>">
                <span class="form__error"><?=isset($errors['cost']) ? $errors['cost'] : "";?></span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
          <?php endif; ?>
          <div class="history">
            <h3>История ставок (<span><?=count($history_rates); ?></span>)</h3>
            <table class="history__list">
              <?php foreach ($history_rates as $rates_item) : ?>
			  <tr class="history__item">
                <td class="history__name"><?= esc($rates_item['name']);?></td>
                <td class="history__price"><?= format_price($rates_item['amount']); ?> р</td>
                <td class="history__time"><?=show_user_frendly_time($rates_item['created_at']);?></td>
              </tr>
			  <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>
