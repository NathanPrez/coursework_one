/* JS hides or shows specific elements */
function hide(name) {
    document.getElementById(name).classList.add("hide");
}

function show(name) {
    var elem = document.getElementById(name).classList;
    if (elem.contains("hide")) {
        document.getElementById(name).classList.remove("hide");
    }
}
 
/* Logs out user */
function submit() {
    document.getElementById('logout-form').submit();
}


/*
For Post creation
Called whenever the select is changed
Checks if post is of type 'Shot'
if so display file upload, otherwise hide
*/
function checkPostType(){
    if(document.forms["post-form"]["type"].value == "shot") {
        show("image-upload");
        document.forms["post-form"]["file"].setAttribute("required", "");
    } else { 
        hide("image-upload");
        document.forms["post-form"]["file"].removeAttribute("required");
    }
}

/*
For user creation
Called whenever the select is changed
Checks if post is of type 'user'
if so display username change and bio
*/
function checkType(){
    if(document.forms["user-form"]["type"].value == "user") {
        show("username-input");
        show("bio-input");
        document.forms["user-form"]["username"].setAttribute("required", "");
    } else { 
        hide("username-input");
        hide("bio-input");
        document.forms["user-form"]["username"].removeAttribute("required");
    }
}

/*
When comment edit button pressed
Opens/hides specific elements
*/
function openEdit(elem) {
    //Hide edit and delete buttons
    elem.parentNode.classList.add("hide");
    //hide comment body
    elem.parentNode.parentNode.childNodes[0].childNodes[0].classList.add("hide");
    //show form
    elem.parentNode.parentNode.childNodes[0].childNodes[2].classList.remove("hide");
}

/*
When comment edit close button pressed
Opens/hides specific elements
*/
function closeEdit(elem) {
    //hide form
    elem.parentNode.classList.add("hide");
    //show comment body
    elem.parentNode.parentNode.childNodes[0].classList.remove("hide");
    //show edit and delete buttons
    elem.parentNode.parentNode.parentNode.childNodes[2].classList.remove("hide");
}
