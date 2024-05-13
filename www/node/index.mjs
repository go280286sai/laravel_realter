import express from 'express';
const app = express();
import path from 'path';
import bodyParser from 'body-parser';
import { start } from './src/app_routes.mjs';
import { getFileRead } from './functions/getFileRead.mjs';
import {removeFiles} from "./functions/removeFiles.mjs";
const jsonParser = bodyParser.json();
app.use(jsonParser);
app.get('/', function (req, res) {
    res.send("hello")
});
app.post("/api/target", function (req, res) {
    const { target, url } = req.body;
    console.log(target, url);
    start(target, url)
    res.send(true)
})
app.get("/api/realtor/:id", async function (req, res) {
    let id = req.params.id;
    let path_file = path.join("files/","realtor");
    let file = await getFileRead(path_file, id);
    res.send(file);
});
app.post('/api/clean', async function (req, res) {
    try {
        let path_file = path.join("files/","realtor");
        await removeFiles(path_file);
    } catch (e) {
        console.log(e);
    }

    res.send(true)
})
app.listen(3000, function () {
    console.log('Example app listening on port 3000!');
});