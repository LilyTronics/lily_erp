/* Do a API call and return the response in a callback */

'use strict';


function apiPost(data, callback, dialog_title)
{
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
            callback(response);
        })
        .catch ((error) => {
            if (showMessage)
            {
                let message = 'Failed to get the color theme:<br />' + escapeHtml(error.message);
                showMessage(dialog_title, message);
            }
            else
            {
                console.log(error);
            }
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
