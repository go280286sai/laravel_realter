import json
import os

from flask import Flask, request, jsonify
import pandas as pd
import requests

from apps.apartment.OlxLinearRegression import OlxLinearRegression

app = Flask(__name__)

from apps.apartment.Analyze import Analyze
from apps.apartment.PredictApartment import PredictApartment
from apps.apartment.PredictListApartment import PredictListApartment
from apps.db.OlxApartment import OlxApartment
from flask_cors import CORS
from apps.apartment.RandomForest import RandomForest
from dotenv import load_dotenv

load_dotenv()
CORS(app, resources={r"/*": {"origins": "http://192.168.50.70:8080/"}})


@app.get('/')
def hello():
    return 'Hello World!'


@app.post('/apartment')
def res():
    body = request.get_json()
    global mae
    token = body['token']
    data = pd.DataFrame(OlxApartment().getData(),
                        columns=['id', 'rooms', 'floor', 'etajnost', 'price', 'date', 'location', 'area',
                                 'favorites'])
    if (data['id'].count() * 0.3 <= data[data['favorites'] == 0]['id'].count()):
        send_data = OlxLinearRegression(data).getData()
        OlxApartment().setNewPrice(send_data[1])
        sendMae(send_data[0], token)
    else:
        send_data = RandomForest(data).getData()
        OlxApartment().setNewPrice(send_data[1])
        sendMae(send_data[0], token)
    analitica = Analyze(data)
    analitica.getImpotenAttribut()
    analitica.getMatrixAnalize()
    OlxApartment().setLocationIndex(analitica.getProfit())
    upload_file(f'{os.getenv('MAIN_HOST')}/api/getFiles', 'apps/files/matrix.png', 'matrix', token)
    upload_file(f'{os.getenv('MAIN_HOST')}/api/getFiles', 'apps/files/importance.png', 'importance', token)
    return jsonify({"status": 200})


@app.post('/predictApartment')
def predict_apartment():
    data = pd.DataFrame(OlxApartment().getData(),
                        columns=['id', 'rooms', 'floor', 'etajnost', 'price', 'date', 'location', 'area',
                                 'favorites'])
    obj = PredictApartment(data)
    req = request.get_json()
    rooms = req['rooms']
    floor = req['floor']
    etajnost = req['etajnost']
    area = req['area']
    location = req['location']
    print(rooms, floor, etajnost, area, location)
    result = obj.getData([int(rooms), int(floor), int(etajnost), int(area), location])
    return jsonify(result)


def upload_file(url, loc, name, token):
    file = open(loc, 'rb')
    requests.post(url, data={'name': name}, files={'file': file}, headers={"Authorization": f"Bearer {token}"})
    file.close()


def sendMae(mae: float, token: str):
    requests.post(f'{os.getenv("MAIN_HOST")}/api/getMae', json={'mae': round(mae, 2)},
                  headers={"Authorization": f"Bearer {token}"})


@app.post('/getPredict')
def get_predict():
    body = request.get_json()
    print(body)
    rooms = body['rooms']
    etajnost = body['etajnost']
    price = body['price']
    location = body['location']
    data = pd.DataFrame(OlxApartment().getData(),
                        columns=['id', 'rooms', 'floor', 'etajnost', 'price', 'date', 'location', 'area',
                                 'favorites'])
    result = PredictListApartment(data).getData([int(rooms), int(etajnost), int(price), location])
    return jsonify({"ids": result})



if __name__ == '__main__':
    app.run('192.168.50.70', 5000, debug=True)
