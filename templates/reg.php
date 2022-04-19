<main>
<?php $classname = (!empty($errors)) ? "form--invalid" : ""; ?>
<form class="form container <?= $classname ?>" action="register.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <?php $classname = !empty($errors['email']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname ?>">
    <label for="email">E-mail <sup>*</sup></label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $values['email'] ?? ''; ?>">
    <span class="form__error"><?= $errors['email'] ?></span>
    </div>
    <?php $classname = !empty($errors['password']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname ?>">
    <label for="password">Пароль <sup>*</sup></label>
    <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= $values['password'] ?? ''; ?>">
    <span class="form__error"><?= $errors['password'] ?></span>
    </div>
    <?php $classname = !empty($errors['name']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname ?>">
    <label for="name">Имя <sup>*</sup></label>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $values['name'] ?? ''; ?>">
    <span class="form__error"><?= $errors['name'] ?></span>
    </div>
    <?php $classname = !empty($errors['message']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $classname ?>">
    <label for="message">Контактные данные <sup>*</sup></label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= getPostVal('message'); ?></textarea>
    <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <?php if (!empty($errors)) : ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <ul>
            <?php foreach ($errors as $val) : ?>
            <li><strong><?= $val; ?>:</strong></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="enter.php">Уже есть аккаунт</a>
</form>
</main>
