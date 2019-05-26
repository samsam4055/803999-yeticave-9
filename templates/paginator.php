<ul class="pagination-list">
	<li class="pagination-item pagination-item-prev <?= $active_page === 1 ? 'pagination-item-active' : ''; ?>">
		<a <?= $active_page > 1 ? 'href="' . $page_link . ($active_page - 1) . '&id=' . $search . '"': ""; ?>>Назад</a>
	</li>
    <?php foreach ($paginator as $item): ?>
	<li class="pagination-item <?= $active_page === $item ? 'pagination-item-active' : ''; ?>">
		<a <?= $active_page !== $item ? 'href="' . ($page_link . $item) . '&id=' . $search . '"' : ''; ?>><?= $item; ?></a>
	</li>
	<?php endforeach; ?>
    <li class="pagination-item pagination-item-next <?= $active_page === $total_pages ? 'pagination-item-active' : ''; ?>">
		<a <?= $active_page !== $total_pages ? 'href="' . $page_link . ($active_page + 1) . '&id=' . $search . '"': ""; ?>>Вперед</a>
	</li>
</ul>
