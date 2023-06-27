# FONNTE-WHATSAPP-API
PHP Class To Communicate with Fonnte WhatsApp API

 * This Helper Class For Communicate with WhatsApp Api fonnte.com 
 * -----------------
 * Helper WhatsApp Text Format
 * use \n For New Line
 * use * for Bold ex: *text*
 * use _ for Italic ex: _text_
 * use ~ for strikethrough ex: ~text~
 * use ``` for monospace ex: ```text```
 * For Include Domain On Footer Just type domain name without http:// or https:// ex: namadomain.com
 * -----------------
 * 
 * How to Use as Helper on Codeigniter v.3:
 * rename This File to fonnte_helper.php
 * Upload This File to Folder system/helpers
 * Load Helper on application/config/autoload.php $autoload['helper'] = array('fonnte'); OR Direct Load $this->load->helper('fonnte');
 * 
 * How to Use as PHP Class
 * Create Folder fonnte and Upload This File to Class Folder OR Vendor
 * rename This File to fonnte.php
 * Call Class
 * include "fonnte/fonnte.php";
 * 
 * ------------------------------
 * Use Class
 * 1. Sending Message
 *    FONNTE::sendMessage($message,$phoneNumberTarget); 
     * Example: 
     * $message = 'TEST SEND MESSAGE';
     * $singleTarget = '6282xxxxxx';
     * $multipleTarget = '6282xxxxxx,6285xxxxxxxx,6283xxxxxxxxx'; //separate with comma,
     * $send = FONNTE::sendMessage($message,$singleTarget);    
     * Output return true or false 
 * 
 * 2. Sending message With Attachment
 *    FONNTE::sendMessageWithAttachment($message,$phoneNumberTarget,$urlFile,$fileName);
     * Example : 
     * $message = 'TEST SEND MESSAGE';
     * $singleTarget = '6282xxxxxx'; //Phone Number Or Group ID 
     * $multipleTarget = '6282xxxxxx,6285xxxxxxxx,6283xxxxxxxxx'; //separate with comma,
     * $urlFile = 'https://domainName/folderFile/FileName';
     * $fileName = 'xxx.pdf'; //support image, file, audio, video | Max size 4MB
     * $send = FONNTE::sendMessageWithAttachment($message,$singleTarget,$urlFile,$fileName);
     * Output return: true or false 
 * 
 * 3. Get QR Device
 *    FONNTE::getDeviceQr();
     * Example : 
     * $qr = FONNTE::getDeviceQr();
     * Output return: QR Image  
 * 
 * 4. Validate Phone Number
 *    FONNTE::validatePhone($phoneNumberTarget);
     * Example : 
     * $singleTarget = '6282xxxxxx';
     * $multipleTarget = '6282xxxxxx,6285xxxxxxxx,6283xxxxxxxxx'; //separate with comma,
     * $qr = FONNTE::validatePhone($singleTarget);
     * Output return: Phone Status
 * 
 * 6. Get List WhatsApp Goup
 *    FONNTE::getListGroup();
     * Example :
     * $List = FONNTE::getListGroup();
     * Output return: array List Group {id,array[member],name}
 * 
 * 7. Check Device Profile 
 *    FONNTE::deviceProfile();   
     * Example :
     * $List = FONNTE::deviceProfile();
     * Output return: array {"device":"","device_status":"connect","expired":"EXPIRED DATE","messages":27,"name":"","package":"","quota":"","status":"true"}
 * 
