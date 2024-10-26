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
    def _execute_query(cls, query):
        cls._connect()
        cursor = cls._connection.cursor()
        cursor.execute(query)
        if query.startswith("SHOW"):
            columns = [column[0] for column in cursor.description]
            return [dict(zip(columns, row)) for row in cursor.fetchall()]
        return None

    @classmethod
    def clear_all(cls, drop_user=False):
        # Delete all tables and start with an empty database
        for table in cls._execute_query("SHOW TABLES"):
            query = "DROP "
            if not drop_user and table["Tables_in_lily_erp_test"] == "user":
                query = "TRUNCATE "
            query += f"TABLE {table["Tables_in_lily_erp_test"]}"
            cls._execute_query(query)
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
    Database.create_default_user()
