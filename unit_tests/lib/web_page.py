"""
Web page class.
Convert HTML into objects for testing.
"""

import re


class WebPage:

    def __init__(self, html):
        self._html = html
        self.page_title = self._get_match(html, r"<title>(.*)</title>")
        self.page_header = self._get_match(html, r"<h\d>(.*)</h\d>")

    def __str__(self):
        output = f"Page title : '{self.page_title}'\n"
        output += f"Page header: '{self.page_header}'\n"
        return output.strip()

    def _get_match(self, haystack, needle_re):
        result = None
        matches = re.findall(needle_re, haystack)
        if len(matches) > 0:
            result = matches[0]
        return result


if __name__ == "__main__":

    from http_request import HttpRequest

    http = HttpRequest()
    page = WebPage(http.do_get().text)
    print(page)
