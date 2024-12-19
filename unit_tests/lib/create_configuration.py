"""
Script for creating the configuration.
"""

from unit_tests.lib.http_request import HttpRequest
from unit_tests.lib.test_settings import TestSettings


def create_configuration():
    post_data = {
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
    http = HttpRequest()
    return http.do_api_call(post_data)


if __name__ == "__main__":

    print(create_configuration())
