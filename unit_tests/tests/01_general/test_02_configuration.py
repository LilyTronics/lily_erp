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
       web_page = self.get_web_page()
       self.fail_if(web_page.page_header != "Setup configuration", "Invalid page received, expected setup configuration")

    def test_create_configuration(self):
        response = create_configuration()
        self.fail_if(not response["result"], response["message"])
        web_page = self.get_web_page()
        self.fail_if(web_page.page_header == "Setup configuration", "Invalid page received ({web_page.page_header})")
        self.fail_if(web_page.page_header != "Log in", f"Invalid page received ({web_page.page_header})")


if __name__ == "__main__":

    TestConfiguration().run()
