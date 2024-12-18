"""
Our own test suite.
"""

from lily_unit_test import TestSuite

from unit_tests.lib.database import Database
from unit_tests.lib.http_request import HttpRequest
from unit_tests.lib.web_page import WebPage


class TestSuiteBase(TestSuite):

    http_request = None
    table_name = ""

    # Setup override
    def setup(self, drop_user=False):
        self.http_request = HttpRequest()
        Database.clear_all(drop_user)
        if not drop_user:
            Database.create_default_user()

    ##########
    # Public #
    ##########

    def get_web_page(self, uri=""):
        response = self.http_request.do_get(uri)
        self.fail_if(response.status_code != 200, f"Invalid response status code: {response.status_code}")
        return WebPage(response.text)


    #############################
    # Test cases for this class #
    #############################

    def test_http_request(self):
        response = self.http_request.do_get()
        self.fail_if(response.status_code != 200, f"Invalid response status code: {response.status_code}")

    def test_get_web_page(self):
        web_page = self.get_web_page()
        print(web_page)


if __name__ == "__main__":

    TestSuiteBase().run()
