"""
Interact with the database.
"""

import mysql.connector

from unit_tests.lib.test_settings import TestSettings


class Database:

    _connection = None

    @classmethod
    def _connect(cls):
        if cls._connection is None:
            cls._connection = mysql.connector.connect(
                host=TestSettings.sql_host,
                user=TestSettings.sql_user,
                password=TestSettings.sql_password,
                database=TestSettings.sql_database
            )

    @classmethod
    def clear_all(cls):
        # Delete all tables and start with an empty database
        cls._connect()
        cursor = cls._connection.cursor()
        cursor.execute("SHOW TABLES")
        for table in cursor:
            cursor.execute(f"DROP TABLE {table[0]}")


if __name__ == "__main__":

    Database.clear_all()
