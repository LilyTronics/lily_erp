"""
Test the account table.
"""

from unit_tests.lib.test_table import TestTable


class TestAccount(TestTable):

    table_name = "account"
    record_test_data = {
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


    def test_table_fields(self):
        return super().test_table_fields()

    def test_add_record_missing_fields(self):
        return super().test_add_record_missing_fields()


if __name__ == "__main__":

    TestAccount().run()
