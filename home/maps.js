var markers = {}; 
var icons = {
    Pub:{icon: "../../images/icons/bar.png"},
    Boat_Club:{icon: "../../images/icons/boat.png"},
    Bridge:{icon: "../../images/icons/bridge_old.png"},
    Mooring:{icon: "../../images/icons/harbor.png"},
    Bouy:{icon: "../../images/icons/kardinalstonne.png"},
    Restaurant:{icon: "../../images/icons/restaurant.png"},
    Slipway:{icon: "../../images/icons/slipway.png"},
    Lock:{icon: "../../images/icons/symbol_blank.png"},
    Facilities:{icon: "../../images/icons/toilets.png"}};
var map = {};
function initialize() {
    //get the poi data from the database
    $.ajax({
        type: "POST",
        url: "http://clinic-match.codio.io:5000/home/map_ajax.php",
        success: function(result){
            console.log(result);
            if (result == ""){ //no maps
                $("#map_content").html("<h3>You haven't created any Maps yet! Share your experiences with other boaters and join the community!</h3>");
            }else{
                var pois = JSON.parse(result); //create json object
                AddMarkers(pois);
                console.log(pois);
            }
        }
    });
    
    function AddMarkers(pois, length){
        var length = Object.keys(pois).length; //number of different POIs
        for (var i = 0; i < length; i++){ //for each PoI
            //add the map
            $("#map_content").append( '<div id="parent"><div id="map_canvas '+pois[i].poi_id+'" style="width:100%; height:100%;"></div></div>');
            var LatLng = {lat: Number(pois[i].latitude), lng: Number(pois[i].longitude)};
            var type = (pois[i].type);
            type = type.replace(/\s/g, "_");
            //makle the map static
            var mapProp = {
                center:new google.maps.LatLng(LatLng),
                zoom:15,
                mapTypeId:google.maps.MapTypeId.TERRAIN,
                disableDefaultUI:true,
                draggable: false, 
                zoomControl: false, 
                scrollwheel: false, 
                disableDoubleClickZoom: true
            };
            //positioning on the page
            map[pois[i].poi_id] = new google.maps.Map(document.getElementById("map_canvas "+pois[i].poi_id), mapProp);
            map[pois[i].poi_id].panBy(0, -140);
            //add the marker to the map 
            var marker = new google.maps.Marker({
                position: LatLng,
                map: map[pois[i].poi_id],
                title: pois[i].name,
                icon: {url: icons[type].icon, scaledSize: new google.maps.Size(37, 43)}
            });
            //add the info window
            var infowindow = new google.maps.InfoWindow({
                content: InfoContent(pois[i], false)
            });
            infowindow.open(map[pois[i].poi_id], marker);
        }
    }     
}

$(document).ready(function(){
     google.maps.event.addDomListener(window, 'load', initialize);
})
