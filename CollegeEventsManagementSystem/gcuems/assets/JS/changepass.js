const loginbackground = document.querySelector('.loginbackground');
const changepass = document.getElementById('changepass');
changepass.addEventListener('click', () => {
    loginModal.style.display = 'flex';
    loginbackground.style.display = 'flex';
});

const closeModal = document.getElementById('closeModal');
closeModal.addEventListener('click', () => {
    loginModal.style.display = 'none';
    loginbackground.style.display = 'none';

});

const clubbackground = document.querySelector('.clubbackground');
const club_unique_id = document.getElementById('club_unique_id');
club_unique_id.addEventListener('click', () => {
    clubModal.style.display = 'flex';
    clubbackground.style.display = 'flex';
});

const closeclub = document.getElementById('closeclub');
closeclub.addEventListener('click', () => {
    clubModal.style.display = 'none';
    clubbackground.style.display = 'none';

});



