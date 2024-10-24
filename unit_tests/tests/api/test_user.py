"""
Test the user table.
"""

from unit_tests.tests.api.api_test_suite import ApiTestSuite


class TestUser(ApiTestSuite):

    def test_get_user(self):
        data = {
            "action": "get_user"
        }
        result = self.do_api_call(data)
        self.log.debug(f"Records: {len(result["records"])}")
        self.fail_if(len(result["records"]) < 1, "No user records")
        self.log.debug(f"Email: {result["records"][0]["email"]}")
        self.log.debug(f"Name: {result["records"][0]["name"]}")


if __name__ == "__main__":

    TestUser().run()
