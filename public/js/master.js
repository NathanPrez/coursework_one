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


function openModal(modalId, body) {
    $(modalId).modal('show');
    document.getElementById('body-update').value = body;
}