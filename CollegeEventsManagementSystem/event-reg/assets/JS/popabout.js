const aboutbackground = document.querySelector('.aboutbackground');
const aboutButton = document.getElementById('aboutButton');
aboutButton.addEventListener('click', () => {
    aboutModal.style.display = 'flex';
    aboutbackground.style.display = 'flex';
});

const closeabout = document.getElementById('closeabout');
closeabout.addEventListener('click', () => {
    aboutModal.style.display = 'none';
    aboutbackground.style.display = 'none';

});