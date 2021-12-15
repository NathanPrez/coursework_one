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


function openEdit(elem) {
    //Hide edit and delete buttons
    elem.parentNode.classList.add("hide");
    //hide comment body
    elem.parentNode.parentNode.childNodes[0].childNodes[0].classList.add("hide");
    //show form
    elem.parentNode.parentNode.childNodes[0].childNodes[2].classList.remove("hide");
}

function closeEdit(elem) {
    //hide form
    elem.parentNode.classList.add("hide");
    //show comment body
    elem.parentNode.parentNode.childNodes[0].classList.remove("hide");
    //show edit and delete buttons
    elem.parentNode.parentNode.parentNode.childNodes[2].classList.remove("hide");
}
