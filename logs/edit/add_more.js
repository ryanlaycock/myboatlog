$(document).ready(function(){
    var crew_count = 0;
    var row_count = 0;
    var row_template ="";
    var crew_template ="";
    
    //PAGE SETUP
    
    $.get('/templates/crew.html', function(template){ //retrieve the crew template and assign to template
        crew_template = template; //assign to crew_template to make it avaialabe
        
    });
    
    $.get('/templates/row.php', function(template){ //retrieve the row template and assign to template
        row_template = template; //assign to row_template to make it avaialabe
        
    });

    //ADDING ELEMENTS
    
    $("#add_crew").click(function(event){//when add_crew button pressed
        event.preventDefault();//stop the button from submitting
        if(crew_count < 6){// ensure only 7 can be made
            crew_count ++;
            $("#crew").append(crew_template); //add the new row to the html div crew
        }
    });

    $("#add_row").click(function(event){ //when add_row button pressed
        event.preventDefault(); //stop the button from submitting
        if(row_count < 30){ // ensure only 29 can be made
            row_count++; 
            $("#log_content").append(row_template); //add the new row to the html div log_content
        }
    });
    
    $("#logbutton").click(function(){
        window.location = "../../logs/index.php";
    });
    $("#mapsbutton").click(function(){
        window.location = "../../maps/index.php";
    });
    $("#homebutton").click(function(){
        window.location = "../../home/index.php";
    });
    
});



