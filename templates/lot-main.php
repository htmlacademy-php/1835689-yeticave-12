        <main>
            <nav class="nav">
                <ul class="nav__list container">
                    <?php foreach ($categories as $category) : ?>
                        <li class="nav__item">
                            <a href="lot.php?category_id=<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <section class="lot-item container">
                <h2><?= htmlspecialchars($lot['title']); ?></h2>
                <div class="lot-item__content">
                    <div class="lot-item__left">
                        <div class="lot-item__image">
                            <img src="<?= htmlspecialchars($lot['image']); ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['title']); ?>">
                        </div>
                        <p class="lot-item__category">Категория: <span><?= htmlspecialchars($category['name']); ?></span></p>
                        <p class="lot-item__description"><?= htmlspecialchars($lot['description']); ?></p>
                    </div>
                    <div class="lot-item__right">
                        <div class="lot-item__state">
                            <? $res = get_dt_range($lot['dt_add']); ?>
                            <div class="lot-item__timer timer<?= ($res < 1) ? 'timer--finishing' : ''; ?>"><?= $res; ?>
                            </div>
                            <div class="lot-item__cost-state">
                                <div class="lot-item__rate">
                                    <span class="lot-item__amount">Текущая цена</span>
                                    <span class="lot-item__cost">10 999</span>
                                </div>
                                <div class="lot-item__min-cost">
                                    Мин. ставка <span><?= formate_cost($lot['cost']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
