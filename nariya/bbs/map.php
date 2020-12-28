<?php
include_once('./_common.php');

function google_map_address_json($lat, $lng) {
	global $nariya;

	$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&language=ko&key='.$nariya['google_key'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
	$json = json_decode(curl_exec($ch), true);
    curl_close($ch);

    return $json;
}

//설정값
list($lat, $lng, $zoom) = explode(",",$geo);
$lat = $lat ? $lat : '37.566535';
$lng = $lng ? $lng : '126.977969';
$zoom = $zoom ? $zoom : 14;

//지역정보
if($place) {
	$address = $place;
} else {
	$json = google_map_address_json($lat, $lng);
	$address = $json['results'][0]['formatted_address'];
}

$address = urlencode($address);

?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>구글지도보기</title>
<link rel="stylesheet" href="../css/nariya.css" type="text/css">
<style>
	body { margin:0; padding:0; -webkit-text-size-adjust:100%; background:#fff; }
	a { color: rgb(51, 51, 51); cursor: pointer; text-decoration: none; }
	a:hover, a:focus, a:active { color: crimson; text-decoration: none; }
	.infowindow { min-width:180px; max-width:280px; line-height:22px; }
	.infoline { height:6px; }
</style>
<script src="<?php echo NA_URL ?>/js/jquery-3.5.1.min.js"></script>
<script src="https://maps.google.com/maps/api/js?v=3.exp&language=ko&region=kr&key=<?php echo $nariya['google_key'] ?>"></script>
<script>
	// 구글맵
	var map;
	var marker;
	var markerimg = '<?php echo NA_URL ?>/img/map-icon.png';
	var infowindow;
	var geocoder;
	var myLatlng;

	function addLoadEvent(func) {
		var oldonload = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		} else {
			window.onload = function() {
				if (oldonload) {
					oldonload();
				}
				func();
			}
		}
	}

	function initialize() {
		myLatlng = new google.maps.LatLng("<?php echo $lat; ?>", "<?php echo $lng; ?>");
		geocoder = new google.maps.Geocoder();
		var myOptions = {
			zoom: <?php echo $zoom; ?>,
			scaleControl: true,
			navigationControl: true,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL,
				position: google.maps.ControlPosition.TOP_RIGHT
			},
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}

		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		marker = new google.maps.Marker({
			position: myLatlng,
			icon: markerimg,
			map: map
		});

		infowindow = new google.maps.InfoWindow();

		var infotxt = '';
		<?php if($marker) { ?>
			infotxt += "<?php echo $marker;?>";
			infotxt += "<div class='infoline'></div>";
		<?php } ?>
		infotxt += "<a href='#' onclick='geocodeAddress();'>자세히 보기</a>";

		infowindow.setContent("<div class='infowindow'>" + infotxt + "</div>");
		infowindow.open(map,marker);

		google.maps.event.addListener(map, 'zoom_changed', function() {
			zoomLevel = map.getZoom(); 
			if (zoomLevel > 19) { 
			  map.setZoom(19); 
			} else if (zoomLevel < 1) { 
			  map.setZoom(1); 
			}   
		});
	}

	function geocodeAddress() {
		var address = "<?php echo $address;?>";

		if(address) {
			address = "place/" + address + "/";
		}

		var url = "https://www.google.co.kr/maps/" + address + "@<?php echo $lat;?>,<?php echo $lng;?>,<?php echo $zoom;?>z?hl=ko";
		window.open(url);
		return false;
	}
</script>
</head>
<body>
	<div class="na-mapwrap" style="padding-bottom:56.25%;">
		<div id="map" class="na-map">
			<div id="map_canvas" class="na-canvas"></div>
		</div>
	</div>
	<script> addLoadEvent(initialize); </script>
</body>
</html>