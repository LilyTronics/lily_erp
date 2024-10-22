/* Contains all API calls */

'use strict';


/* Gather data from the form and send it */
function sendForm(action, title, callback=null)
{
    let data = {
        'action': action,
        'record': {}
    }
    let elms = document.getElementsByName('record_field');
    for (let elm of elms)
    {
        data['record'][elm.id] = elm.value.trim();
    }
    doApiCall(data, title, callback);
}


/* Do the actual API call, this is a separate function for general usage */
function doApiCall(data, title, callback, module_name, table_name)
{
    showModalLoader();
    fetch(`${WEB_ROOT}api`, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {'Content-type': 'application/json; charset=utf-8'}
    })
    .then((response) => {
        hideModalLoader();
        if (!response.ok)
        {
            throw new Error(`Invalid response from the server received (status code: ${response.status})`);
        }
        return response.text();
    })
    .then((text) => {
        let data;
        try
        {
            data = JSON.parse(text);
        }
        catch(error)
        {
            console.log(`Invalid JSON:\n\n${text}`);
            throw new Error(`Invalid data received:<br />${error}`);
        }
        if (data['debug'])
        {
            // For developement purposes, live request should not have a debug field
            console.log(data);
        }
        if (!data['result']) {
            showModal(title, data['message']);
            return;
        }
        // Callback can be function to call or an URI to go to, else just reload the page
        if (typeof callback === 'function')
        {
            data['module_name'] = module_name;
            data['table_name'] = table_name;
            callback(data);
        }
        else if (typeof callback === 'string')
        {
            location.href = `${WEB_ROOT}${callback}`;
        }
        else
        {
            location.reload();
        }
    })
    .catch((error) => {
        showModal(title, error);
    });
}
