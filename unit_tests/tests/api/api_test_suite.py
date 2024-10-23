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

    def _do_api_call(self, data):
        result = Api.do_api_call(data)
        self.log.debug(f"Result: {result["result"]}")
        self.fail_if(not result["result"], f"Error message: {result["message"]}")
        return result


if __name__ == "__main__":

    class _TestApiTestSuite(ApiTestSuite):

        def test_get_user(self):
            data = {
                "action": "get_user"
            }
            result = self._do_api_call(data)
            self.log.debug(f"Records: {len(result["records"])}")

    _TestApiTestSuite().run()
