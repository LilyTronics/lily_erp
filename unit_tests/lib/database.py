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
    def _execute_query(cls, query, val=None):
        cls._connect()
        cursor = cls._connection.cursor()
        cursor.execute(query, val)
        if query.startswith("SHOW") or query.startswith("SELECT"):
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
        query = "INSERT INTO user (email, name, password, is_active, is_admin) VALUES (%s, %s, %s, %s, %s)"
        val = (TestSettings.admin_email, TestSettings.admin_name,
               hashlib.sha256(TestSettings.admin_password.encode()).hexdigest(), 1, 1)
        cls._execute_query(query, val)
        cls._connection.commit()

    @classmethod
    def get_table_columns(cls, table_name):
        return list(map(lambda x: x["Field"], cls._execute_query(f"SHOW COLUMNS FROM {table_name}")))


if __name__ == "__main__":

    Database.clear_all()
    Database.create_default_user()
    print(Database.get_table_columns("user"))
