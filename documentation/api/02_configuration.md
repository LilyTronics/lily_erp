# Configuration

If no configuration exists, a configuration can be created using one API call.

# Create configuration

The following data should be posted to create a configuration.

```
{
    "action": "create-configuration",
    "record": {
        "host_name": "",
        "database": "",
        "db_user_name": "",
        "db_password": "",
        "admin_email": "",
        "admin_name": "",
        "admin_password": "",
    }
}
```

The configuration will be created and the following response is send.

```
{
    "action": "create-configuration,
    "result": true/false,
    "message": ""
}
```

The configuration is only created when there is no configuration. If a configuration is already created, the result will be false.

After the configuration is created, the admin user should be able to login with the credentials (email/password).
