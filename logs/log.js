$(document).ready(function(){    
    $("#logbutton").click(function(){
        window.location = "";
    });
    $("#mapbutton").click(function(){
        window.location = "../maps/";
    });
    
    $("#homebutton").click(function(){
        window.location = "../../home/";
    });
    $("#createbutton").click(function(){
        window.location = "../logs/create/";
    });
    
//      $(document).on('click','#up_vote',function(){
//         event.preventDefault();
//         var button = $('button#up_vote').val();
//         var num_votes = $('input#votes').val();
//         var object = {
//             poi_id: button,
//             votes: num_votes
//         }
//         object = JSON.stringify(object);
//         $.ajax({
//             type: "POST",
//             url: "http://clinic-match.codio.io:5000/maps/up_vote.php",
//             data: object,
//             success: function(result){
//                 window.location.href = "http://clinic-match.codio.io:5000/maps/index.php?poi="+button;
//                 console.log(result);
               
//             }
//         })
//     })
    
    
});
