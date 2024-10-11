"""
Container with test settings.
"""

import os


class TestSettings:

    root_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "../../"))
    uri = "http://localhost:8080/lily_erp/"
    sql_host = "localhost"
    sql_database = "lily_erp_test"
    # These credentials are only used for testing, make sure these are not used in live production servers
    sql_user = "lily_test"
    sql_password = "OnlyForTesting!"


if __name__ == "__main__":

    print(TestSettings.root_path)
    print(TestSettings.uri)
