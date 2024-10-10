# Lily ERP API

All HTTP requests from the web pages are using an API to access the data from the data base.
The same API canbe used for interfacing to other systems.

## HTTP requests

All HTTP request are post messages using JSON formatted messages.
The JSON format is a very well known format and supported by many programming languages.
More information about the format can be found here: https://www.json.org.

## Request URI

The URI for all API requests is: `/api`

So if the URI for your server is: `https://mydomain.com/`,
the all API requests are send to: `https://mydomain.com/api`.


## Posted data

All data is posted in a JSON format and responses are also send in JSON format.
The data that needs to be posted and the responses are depending on the functionality.
