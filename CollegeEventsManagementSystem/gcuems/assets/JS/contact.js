// Get the modal
var modal = document.getElementById('modal');

// Get the button that opens the modal
var openModalBtn = document.getElementById('openModal');

// Get the <span> element that closes the modal
var closeSpan = document.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal
openModalBtn.onclick = function () {
    modal.style.display = 'flex';
};

// When the user clicks on <span> (x), close the modal
closeSpan.onclick = function () {
    modal.style.display = 'none';
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};
