"""
Our own test suite.
"""

from lily_unit_test import TestSuite

from unit_tests.lib.http_request import HttpRequest


class TestSuite(TestSuite):

    http_request = None

    def setup(self):
        self.http_request = HttpRequest()


if __name__ == "__main__":

    class _TestSuite(TestSuite):

        def test_get_web_page(self):
            print(self.http_request.do_get())


    _TestSuite().run()
