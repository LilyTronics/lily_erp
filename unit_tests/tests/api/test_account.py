"""
Test the account table.
"""

from unit_tests.tests.api.api_test_suite import ApiTestSuite


class TestAccount(ApiTestSuite):

    table_name = "account"


    def test_add(self):
        response = self.get_records()
        self.fail_if(len(response["records"]) != 0, "Number of records is not 0")
        record = {
            "parent_id" : 0,
            "level": 1,
            "number": "1000",
            "name": "Assets",
            "debit_credit": "D",
            "category": "Assets"
        }
        self.add_record(record)
        response = self.get_records()
        self.fail_if(len(response["records"]) != 1, "Number of records is not 1")

    def test_update(self):
        response = self.get_records()
        self.fail_if(len(response["records"]) != 1, "Number of records is not 1")
        record = response["records"][0]
        record["name"] = "New name"
        self.update_record(record)
        response = self.get_records()
        self.fail_if(len(response["records"]) != 1, "Number of records is not 1")
        record = response["records"][0]
        self.fail_if(record["name"] != "New name", "The name was not changed")

    def test_delete(self):
        response = self.get_records()
        self.fail_if(len(response["records"]) != 1, "Number of records is not 1")
        record = {
            "id": response["records"][0]["id"]
        }
        self.delete_record(record)
        response = self.get_records()
        self.fail_if(len(response["records"]) != 0, "Number of records is not 0")


if __name__ == "__main__":

    TestAccount().run()

