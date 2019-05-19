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
  <section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
      <?php foreach($rates as $rate): ?>
	  <tr class="rates__item <?=$rate['is_win'] ? 'rates__item--win' : ($rate['is_end'] ? 'rates__item--end' : '');?>">
        <td class="rates__info">
          <div class="rates__img">
            <img src="<?=$rate['img_url'];?>" width="54" height="40" alt="<?=htmlspecialchars($rate['category']);?>">
          </div>
          <div>
		  <h3 class="rates__title"><a href="lot.php?id=<?=$rate['id'];?>"><?=esc($rate['name']);?></a></h3>
		  <p><?=$rate['is_win'] ? esc($rate['contact']) : '';?></p>
		  </div>
        </td>
        <td class="rates__category">
          <?=esc($rate['category']);?>
        </td>
        <td class="rates__timer">
          <div class="timer <?=$rate['is_finishing'] ? 'timer--finishing' : '';?> <?=$rate['is_end'] ? 'timer--end' : '';?> <?=$rate['is_win'] ? 'timer--win' : '';?>">
		  <?=$rate['is_win'] ? 'Ставка выиграла' : ($rate['is_end'] ? 'Торги окончены' : get_lot_timer($rate['time'])); ?>
		  </div>
        </td>
        <td class="rates__price">
           <?=format_price(esc($rate['amount']));?>
        </td>
        <td class="rates__time">
          <?=show_user_frendly_time($rate['created_at']);?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </section>
</main>

</div>
