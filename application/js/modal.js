/* For using the modal dialogs */

'use strict';


function showLoader()
{
    new bootstrap.Modal('#modal-loader').show();
}

function showMessage(title, message)
{
    document.getElementById('modal-message-title').innerHTML = title;
    document.getElementById('modal-message-body').innerHTML = message;
    new bootstrap.Modal('#modal-message').show();
}

function showConfirm(title, message, callback)
{
    document.getElementById('modal-confirm-title').innerHTML = title;
    document.getElementById('modal-confirm-body').innerHTML = message;
    document.getElementById('modal-confirm-btn-yes').addEventListener('click', callback);
    new bootstrap.Modal('#modal-confirm').show();
}
