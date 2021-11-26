<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <?php
    if (isset($_GET['lot_id'])) {
        $lot_id = intval($_GET['lot_id']);
        $res = mysqli_query($link, 'SELECT * FORM `lots` WHERE `id` = $lot_id');
        $lot = mysqli_fetch_all($res, MYSQLI_ASSOC);
      }
      else {
        $content = include_template('error.php', ['error' => mysqli_error($link)]);
      }
    ?>

    <title><?= htmlspecialchars($lot['title']); ?></title>
    <link href="../css/normalize.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>

    <div class="page-wrapper">

        <header class="main-header">
            <div class="main-header__container container">
                <h1 class="visually-hidden">YetiCave</h1>
                <a class="main-header__logo" href="index.html">
                    <img src="../img/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
                </a>
                <form class="main-header__search" method="get" action="https://echo.htmlacademy.ru" autocomplete="off">
                    <input type="search" name="search" placeholder="Поиск лота">
                    <input class="main-header__search-btn" type="submit" name="find" value="Найти">
                </form>
                <a class="main-header__add-lot button" href="add-lot.html">Добавить лот</a>
                <nav class="user-menu">
                    <ul class="user-menu__list">
                        <li class="user-menu__item">
                            <a href="sign-up.html">Регистрация</a>
                        </li>
                        <li class="user-menu__item">
                            <a href="login.html">Вход</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <nav class="nav">
                <ul class="nav__list container">
                    <?php foreach ($categories as $category) : ?>
                        <li class="nav__item<?= $category['code']; ?>">
                            <a href="index.php?category_id=<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <section class="lot-item container">
                <h2><?= htmlspecialchars($lot['title']); ?></h2>
                <div class="lot-item__content">
                    <div class="lot-item__left">
                        <div class="lot-item__image">
                            <img src="..<?= htmlspecialchars($lot['image']); ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['title']); ?>">
                        </div>
                        <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['name']); ?></span></p>
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
    </div>
</body>

</html>
