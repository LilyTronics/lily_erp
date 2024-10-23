"""
This script loads the demo data into the test database.

!!! This will delete all the data from the test database !!!
"""

from unit_tests.lib.api import Api
from unit_tests.lib.database import Database
from unit_tests.lib.test_settings import TestSettings


Database.clear_all()

# Create from scratch
data = {
    "action": "create_configuration",
    "record": {
        "host_name": TestSettings.sql_host,
        "database": TestSettings.sql_database,
        "db_user_name": TestSettings.sql_user,
        "db_password": TestSettings.sql_password,
        "db_repeat_password": TestSettings.sql_password,
        "admin_email": TestSettings.admin_email,
        "admin_name": TestSettings.admin_name,
        "admin_password": TestSettings.admin_password,
        "admin_repeat_password": TestSettings.admin_password
    }
}

response = Api.do_api_call(data, False)
if not response["result"]:
    print(f"Cannot create configuration: {response["message"]}")
    exit()

print("Demo data is loaded")
