from dotenv import load_dotenv

load_dotenv()
import os
import mysql.connector

config = {
    'user': os.getenv('MYSQL_DATABASE_USER'),
    'password': os.getenv('MYSQL_DATABASE_PASSWORD'),
    'host': os.getenv('MYSQL_DATABASE_HOST'),
    'port': os.getenv('MYSQL_DATABASE_PORT'),
    'database': os.getenv('MYSQL_DATABASE_DB'),
    'raise_on_warnings': True
}


class OlxApartment:
    def getData(self):
        connection = mysql.connector.connect(**config)
        with connection.cursor() as cursor:
            cursor.execute(
                "SELECT id, rooms, floor, etajnost, price, date, location, area, favorites " \
                "FROM olx_apartments")
            return cursor.fetchall()

    def setNewPrice(self, data):
        connection = mysql.connector.connect(**config)
        count = data.id.count()
        for i in range(0, count):
            with connection.cursor() as cursor:
                sql = f"UPDATE olx_apartments SET real_price = {int(data['Predict'][i])} WHERE id = {data['id'][i]}"
                cursor.execute(sql)
                connection.commit()

    def setLocationIndex(self, data):
        connection = mysql.connector.connect(**config)
        count = data.id.count()
        for i in range(0, count):
            with connection.cursor() as cursor:
                cursor.execute(
                    f"Update olx_apartments Set location_index = {int(data['predict'][i])} where id = {data['id'][i]}")
                connection.commit()
