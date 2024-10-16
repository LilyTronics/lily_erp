"""
Do API calls.
"""

import json
import requests

from unit_tests.lib.test_settings import TestSettings


class Api:

    _api_uri = f"{TestSettings.uri}api"
    _logged_in = False
    _cookie = None

    @classmethod
    def _do_request(cls, data):
        cookie = dict()
        if cls._cookie is not None:
            cookie = dict(PHPSESSID=cls._cookie)
        response = requests.post(cls._api_uri, data=json.dumps(data), cookies=cookie)
        cls._cookie = response.cookies.get("PHPSESSID")
        try:
            response = response.json()
        except:
            print(response.text)
            raise
        return response

    @classmethod
    def _log_in(cls):
        data = {
            "action": "log_in",
            "record": {
                "email": TestSettings.admin_email,
                "password": TestSettings.admin_password
            }
        }
        response = cls._do_request(data)
        cls._logged_in = response["result"]

    @classmethod
    def do_api_call(cls, data):
        if not cls._logged_in:
            cls._log_in()
        response = cls._do_request(data)
        return response


if __name__ == "__main__":

    post_data = {
        "action": "get_user"
    }
    api_result = Api.do_api_call(post_data)
    print(api_result)
