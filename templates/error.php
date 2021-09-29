    <main> 
        <nav class="nav">
            <ul class="nav__list container">
                <?php foreach ($categories as $category) : ?>
                    <li class="nav__item">
                        <a href="index.php?category_id=<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <section class="lot-item container">
            <h2>Внимание! Ошибка!</h2>
            <p><?= $error; ?></p>
        </section>
    </main>