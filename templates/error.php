<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $index): ?>
            <li class="nav__item">
                <a href="all-lots.php?id=<?=$index['id'];?>"><?=$index['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?=$title;?></h2>
    <p><?=$message;?></p>
</section>
