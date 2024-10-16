"""
API test suite for common API test stuff.
"""

import lily_unit_test

from unit_tests.lib.api import Api
from unit_tests.lib.database import Database


class ApiTestSuite(lily_unit_test.TestSuite):

    def setup(self):
        Database.clear_all()

    def _do_api_call(self, data):
        result = Api.do_api_call(data)
        self.log.debug(f"Result: {result["result"]}")
        self.fail_if(not result["result"], f"Error message: {result["message"]}")
        return result
