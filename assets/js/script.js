var openModal = document.querySelector("#add_task");
var closeModal = document.querySelector("#close_modal");
var modal = document.querySelector("#modal");
// var input = document.querySelector(".add");

openModal.addEventListener('click', function (event) {
    modal.style.display = "block";
});

closeModal.addEventListener("click", function (event) {
    modal.style.display = "none";
});

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var taskDate = document.getElementById("task_date");

var today = new Date().toISOString().split('T')[0];

if (taskDate) {
    taskDate.setAttribute('min', today);
}

