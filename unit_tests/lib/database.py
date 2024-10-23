"""
Interact with the database.
"""

import hashlib
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
            query = "DROP "
            if table[0] == "user":
                query = "TRUNCATE "
            query += f"TABLE {table[0]}"
            cursor.execute(query)
        cls._connection.commit()

    @classmethod
    def create_default_user(cls):
        cls._connect()
        cursor = cls._connection.cursor()
        sql = "INSERT INTO user (email, name, password, is_admin) VALUES (%s, %s, %s, %s)"
        val = (TestSettings.admin_email, TestSettings.admin_name,
               hashlib.sha256(TestSettings.admin_password.encode()).hexdigest(), 1)
        cursor.execute(sql, val)
        cls._connection.commit()


if __name__ == "__main__":

    Database.clear_all()
