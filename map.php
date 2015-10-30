<div id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js"></script>
  <script>
    function initialize() {
      var myLatlng = new google.maps.LatLng(25.68189, -100.30982);
var mapOptions = {
  zoom: 17,
  center: myLatlng
}
var map = new google.maps.Map(document.getElementById("map"), mapOptions);

var marker = new google.maps.Marker({
    position: myLatlng,
    title:"Hello World!"
});

// To add the marker to the map, call setMap();
marker.setMap(map);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  </script>