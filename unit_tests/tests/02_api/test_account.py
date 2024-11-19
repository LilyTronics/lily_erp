"""
Test the account table.
"""

from unit_tests.lib.database import Database
from unit_tests.lib.test_suite_base import TestSuiteBase


class TestAccount(TestSuiteBase):

    table_name = "account"
    table_fields = []

    record_test_values = {
        "parent_id": (0, ),
        "number": ("", ),
        "name": ("", ),
        "debit_credit": ("", ),
        "category": ("", )
    }

    def test_get(self):
        result = self.get_records()
        self.fail_if(len(result["records"]) != 0,
                     f"number of records {len(result["records"])} incorrect, expected 0")

    def test_table_fields(self):
        self.table_fields = Database.get_table_columns(self.table_name)
        self.fail_if("id" not in self.table_fields, "The ID field is missing")
        for table_field in self.table_fields:
            if table_field == "id":
                continue
            self.fail_if(table_field not in self.record_test_values,
                         f"The field '{table_field}' should not be in the table")
        for key in self.record_test_values:
            self.fail_if(key not in self.table_fields, f"The field '{key}' is not in the table")

    # def test_empty_fields(self):
    #     print(self.table_fields)
    #     record_data = {}
    #     response = self.add_record(record_data)
    #     print(response)

    # def test_get_again(self):
    #     result = self.get_records()
    #     print(result)


if __name__ == "__main__":

    TestAccount().run()
