'use strict';

function showTable(module_name, table_name)
{
    if (document.getElementById('record-table'))
    {
        let data = {
            "action": "get_" + table_name
        }
        doApiCall(data, 'Get records', processRecords, module_name, table_name);
    }
}


function processRecords(result)
{
    let container = document.getElementById('record-table');

    if (result['records'] && result['records'].length > 0)
    {
        let records = result['records'];
        // Create table
        let table = document.createElement('table');
        table.classList.add('w3-table-all');
        table.classList.add('w3-hoverable');
        table.classList.add('record-table');
        let head = table.createTHead();
        let body = table.createTBody();
        // Add header
        let row = head.insertRow()
        row.classList.add('w3-theme');
        for (let field in records[0])
        {
            let cell = row.insertCell();
            cell.textContent = fieldToName(field);
            cell.style.whiteSpace = 'nowrap';
        }
        // Add records
        for (let record of records)
        {
            let row = body.insertRow()
            let recordId = "";
            for (let field in record)
            {
                let cell = row.insertCell();
                cell.textContent = formatValue(field, record[field]);
                formatCell(field, cell);
                if (field == "id")
                {
                    recordId = record[field];
                }
            }
            if (recordId != "")
            {
                row.addEventListener("click", function()
                {
                    let table_name = result["table_name"].replace("_", "-");
                    let module_name = result["module_name"];
                    location.href = WEB_ROOT + "show-record/" + module_name + "/" + table_name + "/" + recordId;
                });
            }
        }
        // Remove old table and add new one
        while (container.firstChild)
        {
            container.removeChild(container.firstChild);
        }
        container.appendChild(table);
    }
    else {
        container.innerHTML = "<p>No records in the database</p>";
    }
}


function fieldToName(field)
{
    return field.replace('_', ' ');
}


function formatValue(field, value)
{
    if (field == "amount")
    {
        value = value.replace(/(\.\d{2}[^0]*)(0*)$/, "$1");
    }
    return value;
}


function formatCell(field, cell)
{
    let no_wrap = ['date', 'reference'];
    if (no_wrap.includes(field))
    {
        cell.style.whiteSpace = 'nowrap';
    }
}
