"""
Run all the unit tests.
"""

import os

from lily_unit_test import TestRunner

options = {
    "report_folder": os.path.join(os.path.dirname(__file__), "test_reports"),
    "create_html_report": True,
    "open_in_browser": True,
    "no_log_files": True
}

TestRunner.run(os.path.join(os.path.dirname(__file__), "tests"), options)
