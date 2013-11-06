<?php
/* @var $this ItemController */
/* @var $model Item */

$this->breadcrumbs=array(
    $title['long']=>array('/catalog/'.$title['url']),
    $tag->tag=>array('/catalog/'.$tag->url),
);

$this->menu=array(
);

$this->setPageTitle($model->title." // Совместная покупка SP BRANDS");

?>
<script>
    function addtocart(){
        var id = $("#item-id").text();
        var price = $("#price").text();
        var size = "";
        var color = "";
        if($("#order-size"))  {
            size = $("#order-size").val();
        }
        if($("#order-color"))  {
            color = $("#order-color").val();
        }
        $.getJSON("/order/addcart", { id:id, price:price, size:size, color:color }, function(data) {
            var content = "Товаров: <b>" + data.cart_items + "</b> / Сумма: <b>" + data.cart_price + "</b> руб. <a class='redbutton smalltext' href='/order/cart'>ОФОРМИТЬ ЗАКАЗ</a>";
            $("#minicart-content").html(content);
            var gocartbutton = "<p style='margin-bottom:10px; color:#f7177b; font-weight:bold'>Товар добавлен в корзину!</p><a href='/order/cart' class='bigbutton greyborder blue1'>Перейти в корзину</a>";
            $(".item-addcart").html(gocartbutton);
        });
    }
</script>

<span id='item-id' style='display:none;'><?= $model->id ?></span>

<div class='item-view'>
    <div class='item-left'>
        <div cilass='item-images'>
            <div class='item-image-big'>
                <img id='big-image' src='<?= $model->getImage('big'); ?>'/>
            </div>
            <? if(sizeof($model->getImages())>1): ?>
                <div class='item-thumbs'>
                    <? foreach($model->getImages() as $image): ?>
                        <div class='item-image-small'><img class='item-thumb' data-url='<?= $image['photo_big'] ?>' src='<?= $image['photo_small'] ?>'/></div>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
        </div>
    </div>
    <div class='item-right'>
        <h1><?= $model->title ?></h1>
        <div style='float:left; width:300px;'>
        <div class='item-price'>
            <span id='price'><?= $model->getPrice(); ?></span> <span class='currency'>руб.</span>
        </div>
        <div class='item-row'>
            <span class='item-attr'>Бренд:</span> <a href='/catalog/<?= $tag->url ?>/?brand=<?= $model->collection->id_brand ?>'><?= $model->collection->brand->name; ?></a>
        </div>
        <div class='item-row'>
            <span class='item-attr'>Артикул:</span> <?= $model->getNumber(); ?>
        </div>
        </div>
        <div style='float:right'>
        <img style='width:90px;' src='/images/brands/<?= $model->collection->id_brand ?>.png'>
        </div>
        <div class='clear'></div>

        <? if(strlen($model->descr)>1): ?>
        <div class='item-row'>
            <span class='item-attr'>Описание:</span> <?= $model->descr; ?>
        </div>
        <? endif; ?>

        <? if($model->hasSizes()): ?>
            <div class='item-row'>
                <span class='item-attr'>Размер:</span>
                <select id='order-size'>
                    <? foreach($model->options as $opt): ?>
                        <? if($opt->label=='Размер'): ?>
                            <option value='<?= $opt->id ?>'><?= $opt->option ?></option>
                        <? endif; ?>
                    <? endforeach; ?>
                </select>&nbsp; <a target="_blank" href='/site/page/ramernaya-setka'>> Размерная сетка</a>
            </div>
        <? endif; ?>

        <? if($model->hasColors()): ?>
        <div class='item-row'>
            <span class='item-attr'>Цвет:</span>
            <select id='order-color'>
                <? foreach($model->options as $opt): ?>
                    <? if($opt->label=='Цвет'): ?>
                        <option value='<?= $opt->id ?>'><?= $opt->option ?></option>
                    <? endif; ?>
                <? endforeach; ?>
            </select>
        </div>
        <? endif; ?>

        <div class='item-addcart'>
            <a href='' onclick='addtocart(); return false;' class='bigbutton red2'>Добавить в корзину</a>
        </div>

        <div class='item-collection-header'>
            Коллекция
        </div>
        <? $days = $model->collection->offer->getdaysleft(); ?>
        <? if($days['days']<4): ?>
            <div class='no_days'>Спешите! До окончания сбора заказов всего <b><?= $days['days'].$days['t'] ?></b>!</div>
        <? endif; ?>
        <div class='item-collection yellow1'>
            <a href='/collection/<?= $model->collection->id ?>'><?= $model->collection->title; ?></a>
            <div class='time_left'><?= $days['days'].$days['t'] ?></div>
            <? if($model->collection->offer->need): ?>
            <div style='padding-top:6px;'>Минимальная сумма заказа: <b><?= $model->collection->offer->need ?> руб.</b> </div>
            <div style='padding-top:6px;'><i>Собрано:</i><br>
            <div id='offer_process'>
                <div id='offer_percent' style='width:<?= $model->collection->offer->getpercent() + 100; ?>px'><?= $model->collection->offer->getpercent(); ?> %</div>
            </div>
            </div>
            <? else: ?>
            <div>Без минимальной суммы заказа.</div>
            <? endif; ?>
        </div>
    </div>
    <div class='clear'></div>
</div>

<div class='related'>
    <h3 style='padding-bottom:15px;'>Похожие товары</h3>
    <? $this->renderPartial("_smallgrid",array("items"=>$related)); ?>
</div>
<div class='clear'></div>

<div style='font-size:11px;'>Не упустите возможность купить <?= $model->title ?> дешево!  <?= $tag->tag ?> от <?= $model->collection->brand->name; ?> с бесплатной доставкой по России. <?= $title['long'] ?> - совместная покупка. </div>
