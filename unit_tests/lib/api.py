"""
Do API calls.
"""

import json
import requests

from unit_tests.lib.test_settings import TestSettings


class Api(requests.Session):

    _api_uri = f"{TestSettings.uri}api"

    def _do_request(self, data):
        response = self.post(self._api_uri, data=json.dumps(data))
        try:
            response = response.json()
        except:
            print(response.text)
            raise
        return response

    def log_in(self, email=TestSettings.admin_email, password=TestSettings.admin_password):
        data = {
            "action": "log_in",
            "record": {
                "email": email,
                "password": password
            }
        }
        response = self._do_request(data)
        if not response["result"]:
            raise Exception(f"Could not log in: {response["message"]}")

    def log_out(self):
        data = {
            "action": "log_out"
        }
        response = self._do_request(data)
        if not response["result"]:
            raise Exception(f"Could not log out: {response["message"]}")

    def do_api_call(self, data, auto_log_in=True):
        for i in range(2):
            response = self._do_request(data)
            if auto_log_in and i == 0 and not response["result"] and response["message"] == "Unauthorized":
                self.log_in()
            else:
                break
        return response


if __name__ == "__main__":

    api = Api()

    post_data = {
        "action": "get_user"
    }

    print("\nFirst call")
    api_result = api.do_api_call(post_data)
    print(api_result)

    print("\nSecond call")
    api_result = api.do_api_call(post_data, False)
    print(api_result)

    print("\nLog out")
    api.log_out()

    print("\nThird call")
    api_result = api.do_api_call(post_data, False)
    print(api_result)
