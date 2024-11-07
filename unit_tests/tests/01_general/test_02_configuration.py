"""
Test the account table.
"""

import os

from unit_tests.lib.create_configuration import create_configuration
from unit_tests.lib.test_settings import TestSettings
from unit_tests.lib.test_suite_base import TestSuiteBase


class TestConfiguration(TestSuiteBase):

    def setup(self):
        super().setup(True)
        if os.path.isfile(TestSettings.ini_filename):
            os.remove(TestSettings.ini_filename)

    def test_empty_configuration(self):
       response = self.get_web_page()
       self.fail_if("<h3>Setup configuration</h3>" not in response.text, "Invalid page received, expected setup configuration")

    def test_create_configuration(self):
        response = create_configuration()
        self.fail_if(not response["result"], response["message"])
        response = self.get_web_page()
        self.fail_if("<h3>Setup configuration</h3>" in response.text, "Invalid page received (setup configuration)")
        self.fail_if("<h3>Log in</h3>" not in response.text, "Invalid page received, expected log in")


if __name__ == "__main__":

    TestConfiguration().run()
