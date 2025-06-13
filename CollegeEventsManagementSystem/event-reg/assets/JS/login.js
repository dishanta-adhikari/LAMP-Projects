// Nav bar scripts
function hideSidebar() {
    const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'none'
}
function showSidebar() {
    const sidebar = document.querySelector('.sidebar')
    sidebar.style.display = 'flex'
}

// show login password
function myFunction1() {
    var x = document.getElementById("exampleInputPassword1");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

// Login Form
const loginbackground = document.querySelector('.loginbackground');
const loginButton = document.getElementById('loginButton');
loginButton.addEventListener('click', () => {
    loginModal.style.display = 'flex';
    loginbackground.style.display = 'flex';
});

// close Login
const closeModal = document.getElementById('closeModal');
closeModal.addEventListener('click', () => {
    loginModal.style.display = 'none';
    loginbackground.style.display = 'none';

});


