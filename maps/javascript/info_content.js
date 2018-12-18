function InfoContent(pois, user){
    console.log("info content reached");
    var content = `
<link rel="stylesheet" type="text/css" href="../maps/info_content.css">
<div id="info_window">
<div id="main">
    <h1>Name: `+pois.name+`</h1>
    <p>Type: `+pois.type+`</p>
    <p>Desc: `+pois.description+`</p>`
    if (user){
        content = content + `<p>Added by: `+pois.f_name+` `+pois.s_name+`</p>`;
    }

    if (pois.phone_number != " " && pois.phone_number != ""){
        content = content + `<p>Number: `+pois.phone_number+`</p>`;
    }
    if (pois.email != " " && pois.email != ""){
        content = content + `<p>Email: `+pois.email+`</p>`;
    }
    if (pois.website != " " && pois.website != ""){
        content = content + `<a href=`+pois.website+`>Website</a>`;
    }
    content = content + `
    <p>Last Edit: `+pois.last_edit+`</p>
</div>
<div id="votes">
    <form>
     <button name="up_vote" id="up_vote" type="submit" value="`+pois.poi_id+`"><img id="arrow" src="../images/up_arrow.png"><p>Up</p></button>
     <div id="vote_num"><p id="vote_num_text" style="font-size: 20px;">`+pois.votes+`</p></div>
     <button name="down_vote" id="down_vote" type="submit" value=`+pois.poi_id+`><img id="arrow" src="../images/down_arrow.png"><p>Down</p></button>
    <input type="hidden" id="votes" value="`+pois.votes+`">
    </form>
</div>
</div>`

    return content;

}



// <a href=`+pois.website+`>Website</a>
  //  <p>Email: 