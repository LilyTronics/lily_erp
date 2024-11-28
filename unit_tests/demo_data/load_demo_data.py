"""
This script loads the demo data into the test database.

!!! This will delete all the data from the test database !!!
"""

import os

from unit_tests.lib.database import Database
from unit_tests.lib.http_request import HttpRequest
from unit_tests.lib.test_settings import TestSettings


def create_configuration(http):
    # Create from scratch
    Database.clear_all(True)
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
    response = http.do_api_call(data, False)
    if not response["result"]:
        print(f"Cannot create configuration: {response["message"]}")
        exit()


def load_demo_data(http, path):
    for filename in filter(lambda x: x.endswith(".data"), os.listdir(path)):
        print(f"Load data from: {filename}")
        columns = []
        line_nr = 1
        with open(os.path.join(path, filename), "r") as fp:
            for line in fp.readlines():
                if line.startswith("//") or line == "":
                    line_nr += 1
                    continue
                if len(columns) == 0:
                    # First line must define the columns, columns cannot have spaces
                    columns = list(filter(lambda x: x != "", line.strip().split(" ")))
                    line_nr += 1
                else:
                    # Split values, values can have spaces, values must therefore be separated with at least two spaces
                    values = filter(lambda x: x != "", line.strip().split("  "))
                    # Strip white spaces
                    values = map(lambda x: x.strip(), values)
                    # Strip quotes
                    values = list(map(lambda x: x.strip("\""), values))
                    if len(values) != len(columns):
                        print(f"Error on line {line_nr}: number of values ({len(values)}) "
                              f"is not the same as the number of columns ({len(columns)})")
                    table = filename.split(".")[0]
                    record = dict(zip(columns, values))
                    # Add id = 0
                    record["id"] = 0
                    data = {
                        "action": f"add_{table}",
                        "record": record
                    }
                    response = http.do_api_call(data)
                    if not response["result"]:
                        print(f"Cannot add record: {response["message"]}")
                        print(data)
                        print(response)
                        exit()


if __name__ == "__main__":

    DEMO_PATH = os.path.dirname(__file__)

    _http = HttpRequest()

    create_configuration(_http)
    load_demo_data(_http, DEMO_PATH)

    print("Demo data is loaded")
