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
  <div class="container">
    <section class="lots">
      <h2>Результаты поиска по запросу «<span><?=$search_words;?></span>»</h2>
      <ul class="lots__list">
        <?php foreach($found_lots as $found_item): ?>
		<li class="lots__item lot">
          <div class="lot__image">
            <img src="<?= $found_item['img_url']; ?>" width="350" height="260" alt="Сноуборд">
          </div>
          <div class="lot__info">
            <span class="lot__category"><?= esc($found_item['category']); ?></span>
            <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$found_item['id'];?>"><?= esc($found_item['name']); ?></a></h3>
            <div class="lot__state">
              <div class="lot__rate">
                <span class="lot__amount"><?= $found_item['amount'] !== $found_item['start_price'] ? 'Ставок: ' . count(get_lot_rates($link, $found_item['id'])) : 'Стартовая цена';?></span>
                <span class="lot__cost"><?= $found_item['amount'] ? format_price($found_item['amount']) : format_price($found_item['start_price']);?><b class="rub">р</b></span>
              </div>
              <div class="lot__timer timer <?= add_time_class($found_item['end_at']); ?>">
                <?= get_lot_timer($found_item['end_at']); ?>
              </div>
            </div>
          </div>
        </li>
		<?php endforeach; ?>
      </ul>
    </section>
	<?=$paginator;?>
  </div>
</main>
