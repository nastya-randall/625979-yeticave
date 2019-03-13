<nav class="nav">
  <ul class="nav__list container">
  <?php foreach ($categories as $index): ?>
    <li class="nav__item">
      <a href="all-lots.php?id=<?=$index['id'];?>"><?=$index['name']; ?></a>
    </li>
  <?php endforeach; ?>
  </ul>
</nav>
<form class="form form--add-lot container <?php if(!empty($errors)): ?>form--invalid<?php endif;?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?php if(isset($errors['lot-name'])): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
      <label for="lot-name">Наименование</label>
      <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= isset($lot['lot-name']) ? htmlspecialchars($lot['lot-name']) : ""; ?>">
      <span class="form__error">Введите наименование лота</span>
    </div>

    <?php $value = isset($lot['category']) ? $lot['category'] : ""; ?>

    <div class="form__item <?php if(isset($errors['category'])): ?>form__item--invalid<?php endif;?>"> <!-- form__item--invalid -->
      <label for="category">Категория</label>
      <select id="category" name="category">
        <option>Выберите категорию</option>
      <?php foreach ($categories as $index): ?>
        <option <?= $value == $index['id'] ? "selected": ""; ?> value="<?=$index['id']; ?>"><?= $index['name']; ?></option>
      <?php endforeach; ?>
      </select>
      <span class="form__error">Выберите категорию</span>
    </div>
  </div>

  <div class="form__item form__item--wide <?php if(isset($errors['message'])): ?>form__item--invalid<?php endif;?>">
    <label for="message">Описание</label>
    <textarea id="message" name="message" placeholder="Напишите описание лота"><?= isset($lot['message']) ? htmlspecialchars($lot['message']) : ""; ?></textarea>
    <span class="form__error">Напишите описание лота</span>
  </div>
  <div class="form__item form__item--file <?php if(isset($errors['image'])): ?>form__item--invalid<?php endif;?>"> <!-- form__item--uploaded -->
    <label>Изображение</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
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
  <div class="form__container-three">
    <div class="form__item form__item--small <?php if(isset($errors['lot-rate'])): ?>form__item--invalid<?php endif;?>">
      <label for="lot-rate">Начальная цена</label>
      <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?= isset($lot['lot-rate']) ? htmlspecialchars($lot['lot-rate']) : ""; ?>">
      <span class="form__error"><?= $errors['lot-rate']; ?></span>
    </div>
    <div class="form__item form__item--small <?php if(isset($errors['lot-step'])): ?>form__item--invalid<?php endif;?>">
      <label for="lot-step">Шаг ставки</label>
      <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?= isset($lot['lot-step']) ? htmlspecialchars($lot['lot-step']) : ""; ?>">
      <span class="form__error"><?= $errors['lot-step']; ?></span>
    </div>
    <div class="form__item <?php if(isset($errors['lot-date'])): ?>form__item--invalid<?php endif;?>">
      <label for="lot-date">Дата окончания торгов</label>
      <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?= isset($lot['lot-date']) ? $lot['lot-date'] : ""; ?>">
      <span class="form__error"><?= $errors['lot-date']; ?></span>
    </div>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Добавить лот</button>
</form>