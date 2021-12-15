var editComments = document.querySelectorAll('.open-comment-edit');
console.log(editComments);
for(var x = 0; x < editComments.length ; x++) {
    editComments[x].addEventListener("click", function(event){
        event.preventDefault();
        console.log("test");
    });
}

document.querySelectorAll('.open-comment-edit').forEach(elem => elem.addEventListener("click", () => {
    console.log("test");
    elem.parentNode.classList.remove("hide");
}));