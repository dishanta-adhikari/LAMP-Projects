// Pass data to Edit Modal
var editModal = document.getElementById('editArtistModal');
editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var name = button.getAttribute('data-name');
    var email = button.getAttribute('data-email');

    document.getElementById('editArtistId').value = id;
    document.getElementById('editArtistName').value = name;
    document.getElementById('editArtistEmail').value = email;
});

// Pass data to Delete Modal
var deleteModal = document.getElementById('deleteArtistModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var name = button.getAttribute('data-name');

    document.getElementById('deleteArtistId').value = id;
    document.getElementById('deleteArtistName').textContent = name;
});
