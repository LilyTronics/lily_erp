/* For using the modal dialogs */

'use strict';


function showModalLoader()
{
    let loader = new bootstrap.Modal('#modal-loader');
    loader.show();
    return loader;
}

function showModalMessage(title, message)
{
    document.getElementById('modal-message-title').innerHTML = title;
    document.getElementById('modal-message-body').innerHTML = message;
    new bootstrap.Modal('#modal-message').show();
}

function showModalConfirm(title, message, callback)
{
    document.getElementById('modal-confirm-title').innerHTML = title;
    document.getElementById('modal-confirm-body').innerHTML = message;
    document.getElementById('modal-confirm-btn-yes').addEventListener('click', callback);
    new bootstrap.Modal('#modal-confirm').show();
}
