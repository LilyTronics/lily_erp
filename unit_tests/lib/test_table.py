"""
Base class for testing tables
"""

from unit_tests.lib.database import Database
from unit_tests.lib.test_suite_base import TestSuiteBase


class TestTable(TestSuiteBase):

    table_name = ""
    record_test_data = {}


    # Setup override
    def setup(self):
        super().setup()
        # Make sure table is created and empty
        result = self.get_records()
        self.fail_if(len(result["records"]) != 0,
                     f"Number of records {len(result["records"])} incorrect, expected 0")


    ##########
    # Public #
    ##########

    def get_records(self):
        data = {
            "action": f"get_{self.table_name}"
        }
        return self.http_request.do_api_call(data)

    def add_record(self, record):
        data = {
            "action": f"add_{self.table_name}",
            "record": record
        }
        return self.http_request.do_api_call(data)


    ###############################################
    # Test methods to call from the derived class #
    ###############################################

    def test_table_fields(self):
        fields = Database.get_table_columns(self.table_name)
        for field in fields:
            self.fail_if(field not in self.record_test_data,
                         f"The field '{field}' should not be in the table")
        for field in self.record_test_data:
            self.fail_if(field not in fields, f"The field '{field}' is not in the table")

    def test_add_record_missing_fields(self):
        record = {}
        for field in self.record_test_data:
            if self.record_test_data[field]["is_required"]:
                expected_message = f"The {field} can not be empty.".replace("_", " ")
                result = self.add_record(record)
                self.fail_if(result["result"], "Expected a failed result, but result is passed")
                self.fail_if(result["message"] != expected_message,
                             f"Invalid message received: '{result["message"]}', expected: '{expected_message}'")
                record[field] = self.record_test_data[field]["add_test_value"]


if __name__ == "__main__":

    test = TestTable()
    test.table_name = "account"
    test.record_test_data = {
        "id": {
            "is_required": True,
            "add_test_value": 0
        },
        "number" : {
            "is_required": True,
            "add_test_value": "1000"
        },
        "name" : {
            "is_required": True,
            "add_test_value": "Assets"
        },
        "debit_credit": {
            "is_required": True,
            "add_test_value": "D"
        },
        "category" : {
            "is_required": True,
            "add_test_value": "assets"
        }
    }
    test.run()
