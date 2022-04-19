  <main>
  <?php $classname = (isset($errors)) ? "form--invalid" : ""; ?>
   <form class="form container <?= $classname ?>" action="enter.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
            $value = isset($form['email']) ? $form['email'] : ""; ?>
      <div class="form__item <?= $classname ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" value="<?= $value; ?>" placeholder="Введите e-mail">
        <?php if ($classname) : ?>
        <span class="form__error"><?= $errors['email']; ?></span>
        <?php endif; ?>
      </div>
      <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";
            $value = isset($form['password']) ? $form['password'] : ""; ?>
      <div class="form__item form__item--last <?= $classname ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" value="<?= $value; ?>" placeholder="Введите пароль">
        <?php if ($classname) : ?>
        <span class="form__error"><?= $errors['password']; ?></span>
        <?php endif; ?>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>
