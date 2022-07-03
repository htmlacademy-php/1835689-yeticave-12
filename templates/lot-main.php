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
                        <?php $res = get_dt_range($lot['dt_end']); ?>
                        <div class="lot-item__timer timer <?= ($res < 1) ? 'timer--finishing' : ''; ?>"><?= $res; ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= formate_cost($lot['cost']); ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= formate_cost($lot['step']); ?></span>
                            </div>
                        </div>
                        <?php $classname = (isset($errors)) ? "form--invalid" : ""; ?>
                        <form class="lot-item__form <?= $classname ?>" action="lot.php?lot_id=<?= $lot['id']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                            <?php $classname = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
                            <p class="lot-item__form-item form__item <?= $classname ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" value="<?= getPostVal('cost'); ?>" placeholder="<?= ($lot['cost'] + $lot['step']); ?>">
                                <?php if (isset($errors)) : ?>
                                    <span class="form__error">Введите наименование лота</span>
                                <?php endif; ?>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>
                    <div class="history">
                        <h3>История ставок (<span>10</span>)</h3>
                        <table class="history__list">
                            <?php foreach ($rates as $rate) : ?>
                                <tr class="history__item">
                                    <td class="history__name"><?= htmlspecialchars($rate['name']); ?></td>
                                    <td class="history__price"><?= formate_cost($rate['cost_rate']); ?></td>
                                    <? $number = diffDate($rate['dt_add']); ?>
                                    <td class="history__time"><?= "{$number} " . get_noun_plural_form((int) $number, 'минута', 'минуты', 'минут'); ?> назад</td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
