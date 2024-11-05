"""
Do HTTP requests.
"""

import requests

from unit_tests.lib.test_settings import TestSettings


class HttpRequest(requests.Session):

    def do_get(self, uri=""):
        return self.get(f"{TestSettings.uri}{uri}")


if __name__ == "__main__":

    http_request = HttpRequest()

    print(http_request.do_get())
