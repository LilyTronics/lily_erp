/* Do a API call and return the response in a callback */

'use strict';


function apiPost(data, dialog_title, callback)
{
    let loader = new bootstrap.Modal('#modal-loader')
    loader.show();

    let request = new Request(WEB_ROOT + 'api', {
        method: 'POST',
        body: JSON.stringify(data),
    });
    fetch (request)
        .then ((response) => {
            if (response.status === 200)
            {
                return response.json();
            }
            else
            {
                throw new Error('invalid response status: ' + response.status);
            }
        })
        .then ((response) => {
            if (!response.result)
            {
                throw new Error(response.message);
            }
            if (callback)
            {
                callback(response);
            }
        })
        .catch ((error) => {

            if (showMessage)
            {
                showMessage(dialog_title, escapeHtml(error.message));
            }
            else
            {
                console.log(error);
            }
        })
        .then(() => {
            loader.hide();
        });
}


function escapeHtml(input)
{
    return input
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
