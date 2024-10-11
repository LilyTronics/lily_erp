/* Contains all API calls */

'use strict';


/* Gather data from the form and send it */
function sendForm(action, title, callback)
{
    let data = {
        "action": action,
        "record": {}
    }
    let elms = document.getElementsByName("record_field");
    for (let elm of elms)
    {
        data['record'][elm.id] = elm.value.trim();
    }
    fetch(API_URI, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {'Content-type': 'application/json; charset=utf-8'}
    })
    .then((response) => {
        if (!response.ok)
        {
            throw new Error('Invalid response from the server received (status code: ' + response.status + ')');
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
            throw new Error('Invalid data received:<br />' + error);
        }
        if (!data['result']) {
            showModal(title, data['message']);
            return;
        }
        callback(data);
    })
    .catch((error) => {
        showModal(title, error);
    });
}
