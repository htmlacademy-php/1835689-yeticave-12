<main>
    <section class="lot-item container">
        <h2><?= htmlspecialchars($lot['title']); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= htmlspecialchars($lot['image']); ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['title']); ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['name']); ?></span></p>
                <p class="lot-item__description"><?= htmlspecialchars($lot['description']); ?></p>
            </div>
            <div class="lot-item__right">
                <?php if (isset($_SESSION['user'])) : ?>
                    <div class="lot-item__state">
                        <? $res = get_dt_range($lot['dt_end']); ?>
                        <div class="lot-item__timer timer <?= ($res < 1) ? 'timer--finishing' : ''; ?>"><?= $res; ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <?php if ($cost_rate) : ?>
                                <span class="lot-item__cost"><?= formate_cost($cost_rate); ?></span>
                                <?php else : ?>
                                <span class="lot-item__cost"><?= formate_cost($lot['cost']); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= formate_cost($lot['cost']); ?></span>
                            </div>
                        </div>
                        <form class="lot-item__form" action="rate.php" method="post" autocomplete="off">
                            <?php $classname = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
                            <p class="lot-item__form-item form__item <?= $classname ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" value="<?= getPostVal('cost'); ?>" placeholder="12 000">
                                <?php if (isset($errors)) : ?>
                                <span class="form__error">Введите наименование лота</span>
                                <?php endif; ?>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
