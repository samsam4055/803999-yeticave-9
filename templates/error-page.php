
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
        <section class="lot-item container">
            <h2>Данные не найдены</h2>
            <p><?= $error_message; ?></p>
        </section>
    </main>
