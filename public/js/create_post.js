function checkType(){
    if(document.forms["post-form"]["type"].value = "shot") {
        document.getElementById('image-upload').classList.remove("hide");
    } else { 
        document.getElementById('image-upload').classList.add("hide");
    }
}
