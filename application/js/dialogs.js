/* Shows a dialog window (modal) */

function showModal(title, message)
{
    document.getElementById('modal-title').innerHTML = title;
    document.getElementById('modal-message').innerHTML = message;
    document.getElementById('modal-1').style.display = 'block';
}
