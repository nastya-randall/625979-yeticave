<nav class="nav">
  <ul class="nav__list container">
    <?php foreach ($categories as $index): ?>
      <li class="nav__item">
          <a href="pages/all-lots.html"><?=$index['name']; ?></a>
      </li>
      <?php endforeach; ?>
  </ul>
</nav>
<section class="lot-item container">
  <h2><?=$lot['name'];?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?=$lot['image_path']; ?>" width="730" height="548" alt="Сноуборд">
      </div>
      <p class="lot-item__category">Категория: <span><?=$lot['cat_name'];?></span></p>
      <p class="lot-item__description"><?=$lot['description'];?></p>
    </div>

    <div class="lot-item__right">
      <?php if (!$is_end): ?>
      <div class="lot-item__state">
        <div class="lot-item__timer timer">
          <?=calc_time($lot['dt_end'])?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?=$lot['price'];?> ₽</span>
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка <span><?=$min_bid;?></span>
          </div>
        </div>
        <?php if ($is_visible): ?>
        <?php if ($is_auth): ?>
        <form class="lot-item__form" action="lot.php?id=<?=$lot['id'];?>" method="post">
          <p class="lot-item__form-item form__item <?php if(!empty($errors)): ?>form__item--invalid<?php endif;?>">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="cost" placeholder="<?=$min_bid;?>" value="<?= isset($form['cost']) ? $form['cost'] : ""; ?>">
            <span class="form__error"><?= $errors['cost']; ?></span>
          </p>
          <button type="submit" class="button">Сделать ставку</button>
        </form>
        <?php endif; ?>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <div class="history">
        <h3>История ставок (<span><?=count($bids);?></span>)</h3>
        <table class="history__list">
          <?php if (count($bids) !== 0): ?>
            <?php foreach ($bids as $bid): ?>
            <tr class="history__item">
              <td class="history__name"><?=$bid['name'];?></td>
              <td class="history__price"><?=$bid['bid'];?> ₽</td>
              <td class="history__time"><?=$bid['dt_add'];?></td>
            </tr>
            <?php endforeach; ?>
          <?php else: ?>
          <tr class="history__item">
              <td class="history__name">Нет ставок. Будьте первым!</td>
            </tr>
          <?php endif; ?>
        </table>
      </div>
    </div>
  </div>
</section>
