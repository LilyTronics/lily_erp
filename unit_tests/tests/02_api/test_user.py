"""
Test the user table.
"""

from unit_tests.lib.test_suite_base import TestSuiteBase


class TestUser(TestSuiteBase):

    table_name = "user"

    def test_get(self):
        result = self.get_records()
        self.fail_if(len(result["records"]) != 1,
                     f"number of records {len(result["records"])} incorrect, expected 1")


if __name__ == "__main__":

    TestUser().run()
