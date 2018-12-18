function add_poi(lat, long){

    event.preventDefault();
    
    var name = $('#name').val();
    var description = $('#description').val();
    var type = $('#type').val();
    if($('#email').val()){var email = $('#email').val()}else{var email = " ";}
    if($('#website').val()){var website = $('#website').val()}else{var website = " ";}
    if($('#phone_number').val()){var phone_number = $('#phone_number').val()}else{var phone_number = " ";}
    var object = {
        lat: lat,
        long: long,
        name: name,
        description: description,
        type: type,
        email: email,
        website: website,
        phone_number: phone_number
    };
    object = JSON.stringify(object);
    console.log(object);
    $.ajax({
        type: "POST",
        url: "http://clinic-match.codio.io:5000/maps/create/ajax.php",
        data: object,
        success: function(result){
            console.log(result);
            $("#error").html(result);
            if (result == ""){
                window.location.replace("http://clinic-match.codio.io:5000/maps/index.php");
            }
        }
        
    });
};
              