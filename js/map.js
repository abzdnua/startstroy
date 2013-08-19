var myMap;
ymaps.ready(function () { 
        myMap = new ymaps.Map("map", {
        // Центр карты
        center: [50.426774,30.538409],
        // Коэффициент масштабирования
        zoom: 15,
        // Тип карты
        type: "yandex#map",
         behaviors: ['default', 'scrollZoom']
            });
			
			myMap.controls
        // Кнопка изменения масштаба.
        .add('zoomControl', { left: 5, top: 5 })
        // Список типов карты
        .add('typeSelector')
        // Кнопка изменения масштаба - компактный вариант.
        // Расположим её справа.
        
        // Стандартный набор кнопок
      
    // Создание метки 
var optbal={
                   iconImageHref: '/sc_img/map_point.png', // картинка иконки
                   iconImageSize: [20, 26], // размеры картинки
                   iconImageOffset: [-15, -11],
                   balloonContentSize: [300, 141],
                   balloonLayout: "default#imageWithContent",
                   balloonImageHref: '../img/cont-balloon-back.png',
                   // Смещение картинки балуна
                   balloonImageOffset: [-155, -211],
                   // Размеры картинки балуна
                   balloonImageSize: [370, 211],
                   // Балун не имеет тени
                   balloonShadow: false
                };
//var contentstart='<div style="width:359px;height:138px;"><div title="Закрыть" style="cursor:pointer;margin-left: 342px;background:url(../img/close.png) no-repeat;width:12px;height:11px;position:absolute;z-index:9999;" onclick="myMap.balloon.close()"></div><div class="balloon-logo f-l"></div><div class="balloon-logo_2 f-l"></div><br/> <div class="f-l" style="text-align:left;margin:10px 0 0 15px;font-family:arial;font-size:16px;line-height:1.5;color:#000;">'
var contentend='</div></div>';
myPlacemark = new ymaps.Placemark([50.426774,30.538409], {
                   // balloonContent: contentstart+'г. Макеевка,<br />ул. Депутатская, 19 г'+contentend,
                }, optbal);

// Добавление метки на карту
myMap.geoObjects.add(myPlacemark);
//2
/*var contentstart='<div style="width:359px;height:138px;"><div title="Закрыть" style="cursor:pointer;margin-left: 342px;background:url(../img/close.png) no-repeat;width:12px;height:11px;position:absolute;z-index:9999;" onclick="myMap.balloon.close()"></div><div class="balloon-logo f-l"></div><div class="balloon-logo_2 f-l"></div><br/> <div class="f-l" style="text-align:left;margin:10px 0 0 15px;font-family:arial;font-size:16px;line-height:1.5;color:#000;">'
var contentend='</div></div>';
myPlacemark2 = new ymaps.Placemark([48.078642,38.058897], {
                  balloonContent: contentstart+'г. Макеевка, <br />ул. Скнарева, 50А<br />(062) 341-16-91'+contentend,
                },optbal);

// Добавление метки на карту
myMap.geoObjects.add(myPlacemark2);*/
//3
/*myPlacemark3 = new ymaps.Placemark([48.541743,39.293802], {
                 balloonContent: contentstart+'г. Луганск,<br />ул. Лутугинская, 95Г<br />(0642) 55-57-71'+contentend,
              }, optbal);

// Добавление метки на карту
myMap.geoObjects.add(myPlacemark3);*/
//4
/*myPlacemark4 = new ymaps.Placemark([48.51019,35.095157], {
                    balloonContent: contentstart+'г. Днепропетровск <br />ул. Журналистов, 13<br />(056) 760-45-43'+contentend,
                },optbal);

myMap.geoObjects.add(myPlacemark4);*/

myMap.events.add('boundschange', function (event) {
    if (event.get('newZoom') != event.get('oldZoom')) {
        myMap.balloon.close();
    }
});
$('#mapone').on('click',function()
{
    myMap.setCenter([48.074886,37.955563], myMap.getZoom());
    myPlacemark.balloon.open();
})
$('#maptwo').on('click',function()
{
    myMap.setCenter([48.078642,38.058897], myMap.getZoom());
    myPlacemark2.balloon.open();
})
$('#mapthree').on('click',function()
{
    myMap.setCenter([48.541743,39.293802], myMap.getZoom());
    myPlacemark3.balloon.open();
})
$('#mapfour').on('click',function()
{
    myMap.setCenter([48.51019,35.095157], myMap.getZoom());
    myPlacemark4.balloon.open();
})

})