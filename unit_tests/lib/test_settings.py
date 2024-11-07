"""
Container with test settings.
"""

import os


class TestSettings:

    root_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "../../"))
    ini_filename = os.path.abspath(os.path.join(root_path, "../../lily_erp.ini"))
    uri = "http://localhost:8080/lily_erp/"

    # These credentials are only used for testing, make sure these are not used in live production servers
    sql_host =  "localhost"
    sql_database = "lily_erp_test"
    sql_user = "lily_test"
    sql_password = "OnlyForTest!"

    admin_email = "admin@lily-erp.nl"
    admin_name = "Lily Erp Admin"
    admin_password = "LilyErp"


if __name__ == "__main__":

    print(TestSettings.root_path)
    print(TestSettings.uri)
    print(TestSettings.ini_filename)
