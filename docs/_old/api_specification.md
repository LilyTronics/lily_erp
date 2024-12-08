# Lily ERP API

All HTTP requests from the web pages are using an API to access the data from the data base.
The same API canbe used for interfacing to other systems.

## HTTP requests

All HTTP request are post messages using JSON formatted messages.
The JSON format is a very well known format and supported by many programming languages.
More information about the format can be found here: https://www.json.org.

### Request URI

The URI for all API requests is: `/api`

So if the URI for your server is: `https://mydomain.com/`,
the all API requests are send to: `https://mydomain.com/api`.


### Posted data

All data is posted in a JSON format. The posted data has the following format:

```
{
    "action": "",
    "record": {
        ...
    },
    "options": {
        ...
    }
}
```

The field `action` is mandatory. The fields `record` and `options` are optional.


### Response

All response data is in a JSON format. The posted data has the following format:

```
{
    "action": "",
    "result": true/false,
    "message": "",
    "records": [
        {
            ...
        },
        ...
    ],
    "options": {
        ...
    }
}
```

The fields `action`, `result` and `message` are mandatory. The action must be the same as in the posted data.
If the API call was successful, the result has the value `true`.
In case of an error, the message should contain an error message.
The fields `records` and `options` are optional.

## Actions

The action can be one of the following strings:

| Category           | Action                 | Description                                                  |
|--------------------|------------------------|--------------------------------------------------------------|
| Configuration [^1] | create_configuration   | Creates a configuration, only if no configuration is present |
|                    |                        |                                                              |
| Settings [^2]      | get_setting            | Get one or more settings from the settings table             |
|                    | update_setting         | Update one or more settings in the settings table.           |
|                    |                        |                                                              |
| Other tables       | get_<table_name>       | Get records from the given table                             |
|                    | add_<table_name>       | Add a record to the given table                              |
|                    | update_<table_name>    | Update a record in the given table                           |
|                    | delete_<table_name>    | Delete a record from the given table                         |

The table name is the name as described in the database structure document.

[^1]: a configuration cannot be modified or deleted using the API.
[^2]: settings cannot be added or removed, since they depend on the application.


### Get action

```
{
    "action": "get_product",
}
```

### Add action

```
{
    "action": "add_bom_requirement",
    "record": {
        ...
    }
}
```

The add action requires record data. A new record is added to the database with the posted data.

### Update action

```
{
    "action": "update_purchase_order_line",
    "record": {
        ...
    }
}
```

The update action requires record data. The record data must contain the ID of the record that
needs to be updated and one or more fields that needs to be updated. It is not needed to send
all fields. The new data will be merged with the existing data.

### Delete action

```
{
    "action": "delete_relation_contact",
    "record": {
        ...
    }
}
```

The update action requires record data. The record data must contain the ID of the record that
needs to be deleted. Only the ID field is required. All other fields are ignored.

## Options

The options field can be used in combination with the get action. The following options apply:

| Option           | Description                                                                    |
|------------------|--------------------------------------------------------------------------------|
| filter           | Filter records by the given expression. The expression must be SQL compatible. |
| sort             | Sort records by the given expression. The expression must be SQL compatible.   |
| records_per_page | Set the number of records per page.                                            |
| page_number      | Set the page number                                                            |


The following API call returns all product with 'shoes' in their name:

```
{
    "action": "get_product",
    "option": {
        "filter": "product_name LIKE '%shoes%'"
    }
}
```

This filter will be inserted in the SQL query:

```
SELECT * FROM product WHERE product_name LIKE '%shoes%';
```

The following API call returns all relations sorted by name:

```
{
    "action": "get_product",
    "option": {
        "sort": "name"
    }
}
```

This will be inserted in the SQL query:

```
SELECT * FROM product ORDER BY name;
```

Check the SQL manual for more details on filtering and sorting.

The fields `records_per_page` and `page_number` are used to prevent large amount of records being
transmitted and slowing down the performance.
If these options are not set, the default `records_per_page` from the settings table are used.
If `page_number` is omitted, the first page is returned.
