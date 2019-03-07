<nav class="nav">
  <ul class="nav__list container">
  <?php foreach ($categories as $index): ?>
    <li class="nav__item">
      <a href="all-lots.php?id=<?=$index['id'];?>"><?=$index['name']; ?></a>
    </li>
  <?php endforeach; ?>
  </ul>
</nav>
<form class="form container <?php if(!empty($errors)): ?>form--invalid<?php endif;?>" action="login.php" method="post"> <!-- form--invalid -->
  <h2>Вход</h2>
  <div class="form__item <?php if(isset($errors['email'])): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= isset($form['email']) ? $form['email'] : ""; ?>" required>
    <span class="form__error"><?= $errors['email']; ?></span>
  </div>
  <div class="form__item form__item--last <?php if(isset($errors['password'])): ?>form__item--invalid<?php endif;?>">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= isset($form['password']) ? $form['password'] : ""; ?>" required>
    <span class="form__error"><?= $errors['password']; ?></span>
  </div>
  <button type="submit" class="button">Войти</button>
</form>
