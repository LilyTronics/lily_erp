"""
Run all the unit tests.
"""

import os

from lily_unit_test import TestRunner


root_path = os.path.dirname(__file__)

options = {
    "report_folder": os.path.join(root_path, "test_reports"),
    "create_html_report": True,
    "open_in_browser": True,
    "no_log_files": True,
    "exclude_test_suites": ["TestSuiteBase", "TestTable"]
}

TestRunner.run(os.path.join(root_path, "tests"), options)
