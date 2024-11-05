"""
Test which files can be accessed by HTTP requests.
"""

import os

from unit_tests.lib.test_settings import TestSettings
from unit_tests.lib.test_suite_base import TestSuiteBase


class TestWebAccess(TestSuiteBase):

    def _check_web_access(self, file_path):
        file_path = file_path.replace("\\", "/")

        # All is forbidden
        expected_code = 403
        # The exceptions
        if file_path in ["index.php"]:
            expected_code = 200
        if file_path in ["php_framework/index.php"]:
            expected_code = 404
        if file_path.startswith("application/styles/") and file_path.endswith(".css"):
            expected_code = 200
        if file_path.startswith("application/styles/") and file_path.endswith(".ttf"):
            expected_code = 200
        if file_path.startswith("application/styles/") and file_path.endswith(".woff2"):
            expected_code = 200
        if file_path.startswith("application/js/") and file_path.endswith(".js"):
            expected_code = 200

        self.log.debug(f"Check access for file: {file_path}")
        r = self.http_request.do_get(file_path)
        self.log.debug(f"Request response code: {r.status_code}")
        self.fail_if(r.status_code != expected_code,
                     f"Wrong response code, expected: {expected_code}")

    def test_web_access(self):
        for current_folder, sub_folders, filenames in os.walk(TestSettings.root_path):
            sub_folders.sort()
            rel_path = current_folder[len(TestSettings.root_path) + 1:]
            for filename in filenames:
                self._check_web_access(os.path.join(rel_path, filename))


if __name__ == "__main__":

    TestWebAccess().run()
