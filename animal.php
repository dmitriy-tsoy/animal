<?php include_once('animal.class.php'); ?>
<h1>Кошки</h1>
<?php
World::getInstance()->populate(new Zebra(100));
World::getInstance()->populate(new Mouse(0.15));

$catWeight = 2;
$runDistance = 50;
$stops = 2;
echo 'Дистанция - ' . $runDistance . ' км, средний вес кошек - 3 кг, скорость кошки - 10 км/ч,  коэффицент потери скорости - 0.8, время на передышку - 30 минут';
$cat = new Cat($catWeight);
$runtime = $cat->run($runDistance);
echo '<p>Вес: ' . $catWeight . ' кг;<br />Время бега: ' . $runtime . ' ч;</p>';

$runtimerest = $cat->runWithRest($runDistance, $stops);
echo '<p>Вес: ' . $catWeight . ' кг;<br />Количество остановок: ' . $stops . '<br />Время бега: ' . $runtimerest . ' ч;</p>';


$fatCatWeight = 8;
$fatCat = new Cat($fatCatWeight);
$fatruntime = $fatCat->run($runDistance);
echo '<p>Вес: ' . $fatCatWeight . ' кг;<br />Время бега: ' . $fatruntime . ' ч;</p>';

$fatCat = new Cat($fatCatWeight);
$fatruntimerest = $fatCat->runWithRest($runDistance, $stops);
echo '<p>Вес: ' . $fatCatWeight . ' кг;<br />Количество остановок: ' . $stops . '<br />Время бега: ' . $fatruntimerest . ' ч;</p>';

?>