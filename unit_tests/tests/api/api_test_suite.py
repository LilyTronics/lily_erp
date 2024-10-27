"""
API test suite for common API test stuff.
"""

import lily_unit_test

from unit_tests.lib.api import Api
from unit_tests.lib.database import Database


class ApiTestSuite(lily_unit_test.TestSuite):

    # Must be overridden in the sub class
    table_name = "unknown"

    _api = None

    def setup(self):
        self._api = Api()
        Database.clear_all()
        Database.create_default_user()

    def do_api_call(self, data, check_log_in=True, check_result=True):
        result =  self._api.do_api_call(data, check_log_in)
        self.fail_if(check_result and not result["result"], f"Error message: {result["message"]}")
        return result

    def do_table_action(self, action, record=None):
        data = {"action": f"{action}_{self.table_name}"}
        if record is not None:
            data["record"] = record
        return self.do_api_call(data)

    def get_records(self):
        return self.do_table_action("get")

    def add_record(self, record):
        return self.do_table_action("add", record)

    def update_record(self, record):
        return self.do_table_action("update", record)

    def delete_record(self, record):
        return self.do_table_action("delete", record)


if __name__ == "__main__":

    class _TestApiTestSuite(ApiTestSuite):

        def test_get_user(self):
            data = {
                "action": "get_user"
            }
            result = self.do_api_call(data)
            self.log.debug(f"Records: {len(result["records"])}")

    _TestApiTestSuite().run()
