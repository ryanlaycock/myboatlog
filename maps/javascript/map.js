var latitude = "";
var longitude = "";
var ready = 0;
var done = false;
function initialize() {
    var set = 0;
    var mapProp = {
        center:new google.maps.LatLng(51.508742,-0.120850),
        zoom:5,
        mapTypeId:google.maps.MapTypeId.TERRAIN,
        mapTypeControl: false,
        streetViewControl: false,
        zoomControlOptions:{
            position: google.maps.ControlPosition.RIGHT_CENTER
        }
    };
    var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
    
    map.addListener("click", function (event) {
        latitude = event.latLng.lat();
        longitude = event.latLng.lng();
        console.log( latitude + ', ' + longitude );
        //showPos(latitude, longitude);
        if (set == 0){
            marker = add_marker(latitude, longitude, map);
            set = 1;
        }else{
            marker.setMap(null);
            marker = add_marker(latitude, longitude, map);
        }
        ready = 1;
        if (ready == 1 && $("#type").val() != null && done == false){
            $("#submit").remove();
            $("#button_location").append("<button id='submit'>Submit</button>");
            done = true;
        }
    }); //end addListener
    
         
}
function add_marker(lat, long, map){
    var marker = new google.maps.Marker({
        position: {lat: lat, lng: long},
        map: map
    });
    return marker;
}

function select(form, destination, remove){ 
    var id = "#"+form;
    if (remove == true){
        $(id).remove(); 
    }else{
        $(id).remove(); 
        $.get('../../templates/map/' + form + '.php', function(template){
            $(destination).append(template);
        });
    }
}


$(document).ready(function(){

    google.maps.event.addDomListener(window, 'load', initialize);
    
       
    $("#type").change(function(){
        
        var type = $("#type").val();
        if (ready == 1 && type != null && done == false){
            $("#submit").remove();
            $("#button_location").append("<button id='submit'>Submit</button>");
            done = true;
        }
        if (type == "Boat Club" || type == "Restaurant" || type == "Pub"){
            select("email", "#form_contents", false);
            select("website", "#form_contents", false);
            select("phone_number", "#form_contents", false);  
        }else if (type == "Mooring" || type == "Facilities" || type == "Lock" || type == "Bridge"){
            select("email", "#form_contents", true);
            select("website", "#form_contents", true);
            select("phone_number", "#form_contents", false);   
        }
    });
    
    $("#button_location").on('click', "#submit", function(){
        add_poi(latitude, longitude);
    });

})
    
    



