"""
Our own test suite.
"""

from lily_unit_test import TestSuite

from unit_tests.lib.http_request import HttpRequest


class TestSuiteBase(TestSuite):

    http_request = None

    def setup(self):
        self.http_request = HttpRequest()

    def test_http_request(self):
        r = self.http_request.do_get()
        self.fail_if(r.status_code != 200, f"Invalid response status code: {r.status_code}")


if __name__ == "__main__":

    TestSuiteBase().run()
