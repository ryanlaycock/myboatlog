var markers = {};
var last_open = null;
var new_markers = [];
var info_window_open = false;
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

function initialize() { //set up the map
    var mapProp = { //map properties
        center:new google.maps.LatLng(54.7824752,-3.6360732),
        zoom:6,
        mapTypeId:google.maps.MapTypeId.TERRAIN,
        mapTypeControl: false,
        streetViewControl: false,
        zoomControlOptions:{
            position: google.maps.ControlPosition.RIGHT_CENTER
        }
    };
    map=new google.maps.Map(document.getElementById("googleMap"), mapProp);

    google.maps.event.addListenerOnce(map, 'idle', function(){
        if(!info_window_open){
            LoadPOIS(map);
        }
    });


    google.maps.event.addListener(map, 'dragend', function(){
        if(!info_window_open){
            LoadPOIS(map);
        }
    });

    google.maps.event.addListener(map, 'zoom_changed', function(){
        if(!info_window_open){
            LoadPOIS(map);
        }
    });
}

function AddMarkers(pois, length){

    if(new_markers.length != 0){
        for (var i = 0; i < new_markers.length; i++) {
            new_markers[i].setMap(null);
        }
        new_markers = [];
        console.log(new_markers);
        console.log("cleared")
    }

    var length = Object.keys(pois).length;
    for (var i = 0; i < length; i++){

        var type = (pois[i].type);
        type = type.replace(/\s/g, "_");

        var LatLng = {lat: Number(pois[i].latitude), lng: Number(pois[i].longitude)};
        var marker = new google.maps.Marker({
            poi_id: pois[i].poi_id,
            position: LatLng,
            map: map,
            title: pois[i].name,
            url: "http://clinic-match.codio.io:5000/maps/index.php?poi="+pois[i].poi_id,
            icon: {url: icons[type].icon, scaledSize: new google.maps.Size(37, 43)}
        });

        Info(marker, pois[i], map);
        new_markers.push(marker);
    }
    console.log(markers);
    if(window.location.search.indexOf("?poi=") != -1){
        var poi =  window.location.search.replace("?poi=", "");
        google.maps.event.trigger(markers[poi], 'click');
    }
}

function LoadPOIS(map){

    var marker_request = {
        request: "show_all",
        bounds: map.getBounds().toJSON()
    };
    //
    //console.log(JSON.stringify(data.bounds));
    marker_request = JSON.stringify(marker_request)

    $.ajax({
        type: "POST",
        url: "http://clinic-match.codio.io:5000/maps/map_ajax.php",
        data: marker_request,
        success: function(result){
            console.log(result);
            var pois = JSON.parse(result);
            AddMarkers(pois);
        }
    });
}

function Info(marker, pois, map){

    marker.addListener("click" , function(){    

        info_window_open = true;

        infowindow = new google.maps.InfoWindow({
            content: InfoContent(pois, true)
        });
        if(last_open != null){
            last_open.close();
        };
        last_open = infowindow;

        infowindow.open(map, marker);
        var vote_request = {
            request: "votes", 
            id: pois.poi_id
        };
        vote_request = JSON.stringify(vote_request);
        console.log(vote_request);
        $.ajax({
            type: "POST",
            url: "http://clinic-match.codio.io:5000/maps/map_ajax.php",
            data: vote_request,
            success: function(result){
                console.log(result);
                $("#vote_num_text").text(JSON.parse(result));   
            }
        })


        var LatLng = {lat: Number(pois.latitude), lng: Number(pois.longitude)};
        window.history.pushState("MyBoatLog","MyBoatLog", "http://clinic-match.codio.io:5000/maps/index.php?poi="+pois.poi_id);

        if(info_window_open){
            google.maps.event.addListener(infowindow,'closeclick',function(){
                info_window_open = false;
                window.history.pushState("MyBoatLog","MyBoatLog", "http://clinic-match.codio.io:5000/maps/index.php");
            });
        };



    });
    google.maps.event.addListener(map, "click", function(event) {
        if(info_window_open){
            infowindow.close();
            info_window_open = false;
            window.history.pushState("MyBoatLog","MyBoatLog", "http://clinic-match.codio.io:5000/maps/index.php");
        }
    });



}

$(document).ready(function(){

    google.maps.event.addDomListener(window, 'load', initialize);



    $(document).on('click','#up_vote',function(){
        event.preventDefault();
        var button = $('button#up_vote').val();
        var num_votes = $('input#votes').val();
        var object = {
            poi_id: button,
            votes: num_votes
        }
        object = JSON.stringify(object);
        $.ajax({
            type: "POST",
            url: "http://clinic-match.codio.io:5000/maps/up_vote.php",
            data: object,
            success: function(result){
                $("#vote_num_text").text(result);
            }
        })
    })

    $(document).on('click','#down_vote',function(){
        event.preventDefault();
        var button = $('button#down_vote').val();
        var num_votes = $('input#votes').val();
        var object = {
            poi_id: button,
            votes: num_votes
        }
        object = JSON.stringify(object);
        $.ajax({
            type: "POST",
            url: "http://clinic-match.codio.io:5000/maps/down_vote.php",
            data: object,
            success: function(result){
                $("#vote_num_text").text(result);
            }
        })
    })










})
