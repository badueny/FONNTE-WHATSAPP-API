const { htmlToWhatsapp, standarNoWa } = require('./whatsAppFormatting');

const FONNTE_BASE_URL = process.env.FONNTE_BASE_URL;
const FONNTE_TOKEN = process.env.FONNTE_TOKEN;

async function sendMsgWa(target, message, urlFile='', fileName='') {
    const form = new FormData();
    form.append("target", standarNoWa(target));         // MUST 628...
    form.append("message", htmlToWhatsapp(message));    //clean HTML message for whatsApp format

    if(urlFile!='' && fileName!=''){
        form.append("url", urlFile);
        form.append("filename", fileName);
    }    

   const res = await fetch("https://api.fonnte.com/send", {
        method: "POST",
        headers: {
            Authorization: FONNTE_TOKEN,
        },
        body: form
    });

    const data = await res.json();
    return data.status;
}

async function deviceProfile() {
   const response = await fetch(`${FONNTE_BASE_URL}/device`, {
        method: "POST",
        headers: { Authorization: FONNTE_TOKEN}
    });
    const res = await response.json(); 
    return res;
}

async function getDeviceQr() {
   const response = await fetch(`${FONNTE_BASE_URL}/qr`, {
        method: "POST",
        headers: { Authorization: FONNTE_TOKEN}
    });
    const res = await response.json(); 
    let result = false;
    if(res.status){
        result = `<img src="data:image/png;base64,${res.url}" width="10%">`;
    }
    return result;
}

module.exports = {
  sendMsgWa,
  deviceProfile,
  getDeviceQr
};
