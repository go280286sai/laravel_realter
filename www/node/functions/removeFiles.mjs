import path from 'path';
import fs from 'fs';

async function removeFiles(url) {
    let files = await fs.promises.readdir(url, 'utf8');

    for (let i = 1; i <= files.length; i++) {
        await fs.promises.unlink(path.join(url, files[i]));
    }

    return true;

}

export {removeFiles}