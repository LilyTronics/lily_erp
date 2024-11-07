"""
Do HTTP requests.
"""

import json
import requests

from unit_tests.lib.test_settings import TestSettings


class HttpRequest(requests.Session):

    def do_get(self, uri=""):
        return self.get(f"{TestSettings.uri}{uri}")

    def do_api_post(self, data):
        response = self.post(f"{TestSettings.uri}api", data=json.dumps(data))
        try:
            response = response.json()
        except:
            print(response.text)
            raise
        return response

    def do_api_call(self, data, auto_log_in=True):
        for i in range(2):
            response = self.do_api_post(data)
            if auto_log_in and i == 0 and not response["result"] and response["message"] == "Unauthorized":
                self.log_in()
            else:
                break
        return response

    def log_in(self, email=TestSettings.admin_email, password=TestSettings.admin_password):
        data = {
            "action": "log_in",
            "record": {
                "email": email,
                "password": password
            }
        }
        response = self.do_api_post(data)
        if not response["result"]:
            raise Exception(f"Could not log in: {response["message"]}")
        return response

    def log_out(self):
        data = {
            "action": "log_out"
        }
        response = self.do_api_post(data)
        if not response["result"]:
            raise Exception(f"Could not log out: {response["message"]}")
        return response


if __name__ == "__main__":

    http_request = HttpRequest()

    print("Get    :", http_request.do_get())
    print("Api    :", http_request.do_api_call({"action": "get_user"}))
    print("Log-out:", http_request.log_out())
