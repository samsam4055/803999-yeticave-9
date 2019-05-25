<ul class="pagination-list">
    <?php if ($active_page !== 1): ?>
        <li class="pagination-item pagination-item-prev">
		<a href="<?= $page_link . ($active_page - 1) . '&search=' . $search; ?>">Назад</a></li>
    <?php endif; ?>

    <?php foreach ($paginator as $item): ?>
        <li class="pagination-item <?= $active_page === $item ? 'pagination-item-active' : ''; ?>">
            <a <?= $active_page !== $item ? 'href="' . ($page_link . $item) . '&search=' . $search . '"' : ''; ?>><?= $item; ?></a>
        </li>

    <?php endforeach; ?>

    <?php if ($active_page !== $total_pages) : ?>
        <li class="pagination-item pagination-item-next"><a
                    href="<?= $page_link . ($active_page + 1) . '&search=' . $search; ?>">Вперед</a></li>
    <?php endif; ?>
</ul>
