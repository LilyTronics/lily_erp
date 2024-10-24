"""
API test suite for common API test stuff.
"""

import lily_unit_test

from unit_tests.lib.api import Api
from unit_tests.lib.database import Database


class ApiTestSuite(lily_unit_test.TestSuite):

    def setup(self):
        Database.clear_all()
        Database.create_default_user()

    def do_api_call(self, data, check_log_in=True, check_result=True):
        result = Api.do_api_call(data, check_log_in)
        self.log.debug(f"Result: {result["result"]}")
        self.fail_if(check_result and not result["result"], f"Error message: {result["message"]}")
        return result


if __name__ == "__main__":

    class _TestApiTestSuite(ApiTestSuite):

        def test_get_user(self):
            data = {
                "action": "get_user"
            }
            result = self.do_api_call(data)
            self.log.debug(f"Records: {len(result["records"])}")

    _TestApiTestSuite().run()
