<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">

        <!--PHP код для заполнения списка из массива категорий-->

        <?php foreach ($categories as $index): ?>
        <li class="promo__item promo__item--boards">
            <a class="promo__link" href="all-lots.php?id=<?=$index['id'];?>" style="background-image:url(../<?=$index['image_path'];?>); background-position: right top;"><?=$index['name']; ?></a>
        </li>
        <?php endforeach; ?>
        <!--end-->
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <!--заполните этот список из массива с товарами-->
        <?php foreach ($lots as $lot): ?>
            <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=$lot['image_path']; ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=$lot['cat_name']; ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id'];?>"><?=htmlspecialchars($lot['name']); ?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?=format_cost($lot['price']); ?>
                        </span>
                    </div>
                    <div class="lot__timer timer">
                        <?=calc_time($lot['dt_end'])?>
                    </div>
                </div>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</section>