/* Do a API call and return the response in a callback */

'use strict';


function apiPost(data, dialog_title, callback, params=null, showLoader=true)
{
    let loader = null;
    if (showLoader)
    {
        loader = showModalLoader();
    }

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
                callback(response, params);
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
            if (loader)
            {
                loader.hide();
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

function populateDataList(listName)
{
    let list_id = 'list_' + listName;
    let elm = document.getElementById(list_id);
    if (!elm)
    {
        // No element found
        return;
    }
    if (elm.options.length > 0)
    {
        // List already populated
        return;
    }
    let data = {};
    data.action = list_id;
    apiPost(data, 'Get records for ' + listName + ' list', processDataList, list_id, false);
}


function processDataList(response , list_id)
{
    let elm = document.getElementById(list_id);
    if (!elm)
    {
        // No element found
        return;
    }
    if (elm.options.length > 0)
    {
        // List already populated
        return;
    }
    if (!response.result)
    {
        // Bad response
        return;
    }
    if (response.records.length > 0)
    {
        response.records.forEach(record => elm.appendChild(new Option('', record)))
    }
}
