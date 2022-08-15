<section class="lots">
    <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($_GET['search']); ?></span>»</h2>
        <ul class="lots__list">
            <?php foreach ($lots as $lot) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= htmlspecialchars($lot['image']); ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['title']); ?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($lot['name']); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?lot_id=<?= $lot['id']; ?>"><?= htmlspecialchars($lot['title']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= formate_cost($lot['cost']); ?></span>
                            </div>
                            <?php $res = get_dt_range($lot['dt_end']); ?>
                            <div class="lot__timer timer <?= ($res < 1) ? 'timer--finishing' : ''; ?>"><?= $res; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
