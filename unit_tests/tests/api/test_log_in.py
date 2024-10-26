"""
Test the log in.
"""

from unit_tests.tests.api.api_test_suite import ApiTestSuite


class TestLogIn(ApiTestSuite):

    PUBLIC_ACTIONS = ["create_configuration", "log_in", "log_out"]
    UNAUTHORIZED_ACTIONS = ["get", "add", "update", "delete"];

    def test_not_logged_in(self):
        self.log.debug("Test actions that should work when not logged in")
        for action in self.PUBLIC_ACTIONS:
            self.log.debug(f"Action: '{action}'")
            data = {"action": action, "record": {}}
            response = self.do_api_call(data, False, False)
            if not response["result"]:
                self.log.debug(f"Message: '{response["message"]}'")
                self.fail_if(response["message"] == "Unauthorized", "Invalid message received")

        self.log.debug("Test actions that should not work when not logged in")
        for action in self.UNAUTHORIZED_ACTIONS:
            action += "_user"
            self.log.debug(f"Action: '{action}'")
            data = {"action": action, "record": {}}
            response = self.do_api_call(data, False, False)
            self.fail_if(response["result"], "Result should be false")
            self.log.debug(f"Message: '{response["message"]}'")
            self.fail_if(response["message"] != "Unauthorized", "Invalid message received")


if __name__ == "__main__":

    TestLogIn().run()
