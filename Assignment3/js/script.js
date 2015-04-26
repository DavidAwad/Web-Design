var current_hour = new Date().getHours();

function editTime(greeting){
  var pText = document.getElementById("greetingONE");
  if(name === "morning"){
    pText.innerHTML = "Morning : D" ;
  }else{
    pText.innerHTML = "Afternoon" ;
  }
  return 1 ;
}

if(current_hour >= 12 ){
  // it's the afternoon / evening
  console.log("good afternoon.");
  editTime("afternoon");

}else{
  //
  editTime("morning");
  console.log("good morning");
}

console.log(current_hour);
