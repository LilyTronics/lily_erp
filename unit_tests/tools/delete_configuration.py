"""
Delete the configuration data.

Configuration data is two parts:
- Ini file with configuration settings
- Database with a user table and an admin account.

Variants:

 variant | Ini file | Database | User table | Admin account
---------+----------+----------+------------+---------------
    1    |   no     |   no     |    no      |     no
    2    |   yes    |   no     |    no      |     no
    3    |   yes    |   yes    |    no      |     no
    4    |   yes    |   yes    |    yes     |     no
    5    |   yes    |   yes    |    yes     |     yes

"""

import os

from unit_tests.lib.test_settings import TestSettings


def delete_configuration(variant):
    if variant == 1:
        if os.path.isfile(TestSettings.ini_filename):
            os.remove(TestSettings.ini_filename)


if __name__ == "__main__":

    delete_configuration(1)
