<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category) : ?>
                <li class="nav__item">
                    <a href="category_show.php?category_id=<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <?php foreach ($bets as $bet) : ?>
            <table class="rates__list">
                <tr class="rates__item">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?= htmlspecialchars($bet['image']); ?>" width="54" height="40" alt="<?= htmlspecialchars($bet['title']); ?>">
                        </div>
                        <h3 class="rates__title"><a href="lot.php?lot_id=<?= $lot['id']; ?>"><?= htmlspecialchars($bet['title']); ?></a></h3>
                    </td>
                    <td class="rates__category">
                        <?= htmlspecialchars($bet['name']); ?>
                    </td>
                    <td class="rates__timer">
                        <?php $res = get_dt_range($bet['dt_end']); ?>
                        <div class="timer <?= ($res < 1) ? 'timer--finishing' : ''; ?>"><?= $res; ?></div>
                    </td>
                    <td class="rates__price">
                        <?= formate_cost($bet['cost_rate']); ?>
                    </td>
                    <?php $number = diffDate($bet['dt_add']); ?>
                    <td class="rates__time">
                    <?= "{$number} " . get_noun_plural_form((int) $number, 'минута', 'минуты', 'минут'); ?> назад
                    </td>
                </tr>
            </table>
        <?php endforeach; ?>
    </section>
</main>
