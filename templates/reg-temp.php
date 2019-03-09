<nav class="nav">
  <ul class="nav__list container">
  <?php foreach ($categories as $index): ?>
    <li class="nav__item">
      <a href="all-lots.php?id=<?=$index['id'];?>"><?=$index['name']; ?></a>
    </li>
  <?php endforeach; ?>
  </ul>
</nav>
<form class="form container <?php if(!empty($errors)): ?>form--invalid<?php endif;?>" action="reg.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Регистрация нового аккаунта</h2>

  <div class="form__item <?php if(isset($errors['email'])): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= isset($form['email']) ? $form['email'] : ""; ?>" required>
    <span class="form__error"><?= $errors['email']; ?></span>
  </div>
  <div class="form__item <?php if(isset($errors['password'])): ?>form__item--invalid<?php endif;?>">
    <label for="password">Пароль*</label>
    <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= isset($form['password']) ? $form['password'] : ""; ?>" required>
    <span class="form__error">Введите пароль</span>
  </div>
  <div class="form__item <?php if(isset($errors['name'])): ?>form__item--invalid<?php endif;?>">
    <label for="name">Имя*</label>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= isset($form['name']) ? $form['name'] : ""; ?>" required>
    <span class="form__error">Введите имя</span>
  </div>
  <div class="form__item <?php if(isset($errors['message'])): ?>form__item--invalid<?php endif;?>">
    <label for="message">Контактные данные*</label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?= isset($form['message']) ? $form['message'] : ""; ?></textarea>
    <span class="form__error">Напишите как с вами связаться</span>
  </div>
  <div class="form__item form__item--file form__item--last <?php if(isset($errors['image'])): ?>form__item--invalid<?php endif;?>">
    <label>Аватар</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" name="image" id="photo2" value="">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
    <span class="form__error"><?php if(isset($errors['image'])){ print $errors['image'];}else{print '';}?></span>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
