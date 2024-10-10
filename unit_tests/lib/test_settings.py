"""
Container with test settings.
"""

import os


class TestSettings:

    root_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "../../"))
    uri = "http://localhost:8080/lily_erp/"


if __name__ == "__main__":

    print(TestSettings.root_path)
    print(TestSettings.uri)
