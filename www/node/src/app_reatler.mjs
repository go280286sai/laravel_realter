import {Realtor} from "./olx/Realtor.mjs";

const run = async (url) => {
    const prefix = "&page=";
    try {
        let obj = new Realtor();
        await obj.getUrls(url);
        await obj.getUrl();
        await obj.saveData(1);
        for (let i = 2; i <= 25; i++) {
            console.log(i, " of 25");
            obj = new Realter();
            await obj.getUrls(url+prefix+i);
            await obj.getUrl();
            await obj.saveData(i);
        }

    } catch {
        console.error
    }
}
export {run};
