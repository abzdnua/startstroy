var Map2 = function(){
	var $this = this;
	/** Объект карты Google */
	var map;
	/** координаты Эквицентра */
	var eqLocation;
	/** маркер Эквицентра */
	var eqMarker;
	/** маркер, который будет отображен как результат поиска маршрута */
	var homeMarker;
	/** всплывающая подсказка к маркеру эквицентра */
	var eqInfo;
	/** тип маршрута, который будет прокладываться на карте */
	var travellingMode = google.maps.TravelMode.DRIVING;
	/** геокодирование результатов */
	var geocoder = new google.maps.Geocoder();

	var info;

	/** язык сайта */
	var lang;

	var googleErrors = [];

	/** отменяем вывод маркеров на карту при рендере */
	var directionsRenderOptions = {
		suppressMarkers: true
	};

	var directionsDisplay = new google.maps.DirectionsRenderer(directionsRenderOptions);
	var directionsService = new google.maps.DirectionsService();

	/** проложение маршрута */
	this.route = function(){
		var request = {
		    origin: $('.a input').val(),
		    destination: eqLocation,
		    travelMode: travellingMode
		};

		directionsService.route(request, function(response, status) {
			switch (status){
				case google.maps.DirectionsStatus.OK:
					directionsDisplay.setDirections(response);
					var address = $('.a > input').val();
					geocoder.geocode({'address' : address},function(results,status){
						addHomeMarker(results[0].geometry.location,address);
					});
					break;
				case google.maps.DirectionsStatus.NOT_FOUND:
					alert(googleErrors[0]);
					break;
				case google.maps.DirectionsStatus.ZERO_RESULTS:
					alert(googleErrors[1]);
					break;
			}
		});
	}
	/** добавляем маркер начала поиска */
	function addHomeMarker(position, content){
		if (typeof(info) != 'undefined'){
			info.close();
		}
		info = new google.maps.InfoWindow();
		info.setContent(content);
		info.setPosition(position);

		if (typeof (homeMarker) != 'undefined'){
			homeMarker.setPosition(position);
		} else {
			homeMarker = new google.maps.Marker({
				position: position,
				map: map,
				icon: 'img/marker_start.png',

			});
			google.maps.event.addListener(homeMarker,'click',function(){
				info.open(map);
			});
		}
	}

	/** смена типа прокладывания маршрута */
	this.changeTravellingMode = function(){
		$(this).siblings().removeClass('selected').end().addClass('selected');
		if ($('.travelling-mode').index($(this)) == 0){
			travellingMode = google.maps.TravelMode.DRIVING;
		} else {
			travellingMode = google.maps.TravelMode.WALKING;
		}
		if ($.trim($('.a>input').val()) != '') $this.route();
	}

	/** определение и установка языка */
	function determineLang(){
		var href = window.location.href;
		var regExp = /\/rus\//;
		if (href.search(regExp) != -1){
			lang = 'rus';
		} else {
			lang = 'eng';
		}
	}
	/** инициализируем языковые настройки */
	function initLang(){
		switch(lang){
			case 'rus':
				googleErrors[0] = "Адрес не найден. Пожалуйста, проверьте правильность введенного адреса!";
				googleErrors[1] = "Адрес не найден. Пожалуйста, проверьте правильность введенного адреса.";
				break;
			case 'eng':
				googleErrors[0] = "Address not found. Please check the entered address!";
				googleErrors[1] = "Sorry... No route could be found between the origin and destination!";
				break;
		}
	}

	/** инициализация */
	(function


        init(){
		determineLang();
		initLang();

		eqLocation = new google.maps.LatLng(48.020386,37.765061);
		var mapOptions = {
			zoom: 14,
			center:  new google.maps.LatLng(48.020386,37.775063),


			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false
		};
		map = new google.maps.Map(document.getElementById('map'),mapOptions);
		directionsDisplay.setMap(map);

		eqMarker = new google.maps.Marker({
			position: eqLocation,
			map: map,
			icon: 'img/img_place.png',
			title: 'Start Stroi',

		});

		eqInfo = new google.maps.InfoWindow({
			content:'<div class="dfdf" style="width: 210px;padding-left: 140px;padding-top: 18px;">Донецк, ул. Шахтеров Донбасса, 1з</div> '

		});

		google.maps.event.addListener(eqMarker,'click',function(){
			eqInfo.open(map,eqMarker);
		});
	})();
}



var Map3 = function(){
    var $this = this;
    /** Объект карты Google */
    var map;
    /** координаты Эквицентра */
    var eqLocation;
    /** маркер Эквицентра */
    var eqMarker;
    /** маркер, который будет отображен как результат поиска маршрута */
    var homeMarker;
    /** всплывающая подсказка к маркеру эквицентра */
    var eqInfo;
    /** тип маршрута, который будет прокладываться на карте */
    var travellingMode = google.maps.TravelMode.DRIVING;
    /** геокодирование результатов */
    var geocoder = new google.maps.Geocoder();

    var info;

    /** язык сайта */
    var lang;

    var googleErrors = [];

    /** отменяем вывод маркеров на карту при рендере */
    var directionsRenderOptions = {
        suppressMarkers: true
    };

    var directionsDisplay = new google.maps.DirectionsRenderer(directionsRenderOptions);
    var directionsService = new google.maps.DirectionsService();

    /** проложение маршрута */
    this.route = function(){
        var request = {
            origin: $('#main2 .a input').val(),
            destination: eqLocation,
            travelMode: travellingMode
        };

        directionsService.route(request, function(response, status) {
            switch (status){
                case google.maps.DirectionsStatus.OK:
                    directionsDisplay.setDirections(response);
                    var address = $('#main2 .a > input').val();
                    geocoder.geocode({'address' : address},function(results,status){
                        addHomeMarker(results[0].geometry.location,address);
                    });
                    break;
                case google.maps.DirectionsStatus.NOT_FOUND:
                    alert(googleErrors[0]);
                    break;
                case google.maps.DirectionsStatus.ZERO_RESULTS:
                    alert(googleErrors[1]);
                    break;
            }
        });
    }
    /** добавляем маркер начала поиска */
    function addHomeMarker(position, content){
        if (typeof(info) != 'undefined'){
            info.close();
        }
        info = new google.maps.InfoWindow();
        info.setContent(content);
        info.setPosition(position);

        if (typeof (homeMarker) != 'undefined'){
            homeMarker.setPosition(position);
        } else {
            homeMarker = new google.maps.Marker({
                position: position,
                map: map,
                icon: 'img/marker_start.png',

            });
            google.maps.event.addListener(homeMarker,'click',function(){
                info.open(map);
            });
        }
    }

    /** смена типа прокладывания маршрута */
    this.changeTravellingMode = function(){
        $(this).siblings().removeClass('selected').end().addClass('selected');
        if ($('#main2 .travelling-mode').index($(this)) == 0){
            travellingMode = google.maps.TravelMode.DRIVING;
        } else {
            travellingMode = google.maps.TravelMode.WALKING;
        }
        if ($.trim($('#main2 .a>input').val()) != '') $this.route();
    }

    /** определение и установка языка */
    function determineLang(){
        var href = window.location.href;
        var regExp = /\/rus\//;
        if (href.search(regExp) != -1){
            lang = 'rus';
        } else {
            lang = 'eng';
        }
    }
    /** инициализируем языковые настройки */
    function initLang(){
        switch(lang){
            case 'rus':
                googleErrors[0] = "Адрес не найден. Пожалуйста, проверьте правильность введенного адреса!";
                googleErrors[1] = "Адрес не найден. Пожалуйста, проверьте правильность введенного адреса.";
                break;
            case 'eng':
                googleErrors[0] = "Address not found. Please check the entered address!";
                googleErrors[1] = "Sorry... No route could be found between the origin and destination!";
                break;
        }
    }

    /** инициализация */
    (function init(){
        determineLang();
        initLang();

        eqLocation = new google.maps.LatLng(48.033244,37.782346);
        var mapOptions = {
            zoom: 14,
            center:  new google.maps.LatLng(48.033244,37.782346),


            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };
        map = new google.maps.Map(document.getElementById('map2'),mapOptions);
        directionsDisplay.setMap(map);

        eqMarker = new google.maps.Marker({
            position: eqLocation,
            map: map,
            icon: 'img/img_place.png',
            title: 'Start Stroi',

        });

        eqInfo = new google.maps.InfoWindow({
            content:'<div class="dfdf" style="width: 210px;padding-left: 140px;padding-top: 18px;">Донецк, ул. Тренева, 1</div> '

        });

        google.maps.event.addListener(eqMarker,'click',function(){
            eqInfo.open(map,eqMarker);
        });
    })();
}



/** строим маршруты по нажатию ENTER'а */
var enter = function(e){
	if (e.keyCode == 13){
		$('.google-map-route > .button').trigger('click');
	}
}

$(function map_my(){
    var map = new Map2();
    $('#main .google-map-route > .button').bind('click',map.route);
    $('#main .travelling-mode').bind('click',map.changeTravellingMode);
    $('input').bind('keyup', enter);

});

$(function map_my2(){
    var map = new Map3();
    $('#main2 .google-map-route > .button').bind('click',map.route);
    $('#main2 .travelling-mode').bind('click',map.changeTravellingMode);
    $('input').bind('keyup', enter);

});
$(function SDFFD(){

	//$('.google-map-route input:first').focus();

});
