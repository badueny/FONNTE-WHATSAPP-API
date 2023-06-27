<?php

/**
 * This Helper Class For Communicate with WhatsApp Api fonnte.com 
 * -----------------
 * Helper WhatsApp Text Format
 * use \n For New Line
 * use * for Bold ex: *text*
 * use _ for Italic ex: _text_
 * use ~ for strikethrough ex: ~text~
 * use ``` for monospace ex: ```text```
 * Included Domain Name On Message OR Footer just type domain name without http:// or https:// ex: namadomain.com
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
*/

/* REQUIRED CONFIGURATIONS */
    define('TOKEN_API_FONNTE', 'YOUR_TOKEN');  //Get from https://md.fonnte.com/new/device.php
    define('HEADER_MESSAGE', "Hai,\n\n");     //Open Close Must Use " DONT USE '    
    define('FOOTER_MESSAGE', "\n\n\nBest Regards,\n*YOU_COMPANY*\nYOUR_WEBSITE_URL"); //Open Close Must Use double quote " DONT USE single quote '
    //Important! Included Domain On Footer just type domain name without http:// or https:// ex: namadomain.com
/* ====================== */

class FONNTE 
{        
    public static function sendMessage($message,$target)
    {   
        $result = false;
        $stsDevice = self::deviceStatus();
        if($stsDevice==true){
            $curl = curl_init();
            curl_setopt_array($curl, [
              CURLOPT_URL => 'https://api.fonnte.com/send',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => ['target' => $target,'message' => HEADER_MESSAGE.str_replace(["https://","/","//","http://"],['','','',''],$message).FOOTER_MESSAGE],
              CURLOPT_HTTPHEADER => ['Authorization: '.TOKEN_API_FONNTE],
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            $status = json_decode($response, TRUE);
            if($status['status']==true){
                $result = true;
            }
        }
        return $result;
    }
    
    public static function sendMessageWithAttachment($message,$target,$urlFile,$fileName)
    {   
        $result = false;
        $stsDevice = self::deviceStatus();
        if($stsDevice==true){
            $curl = curl_init();
            curl_setopt_array($curl, [
              CURLOPT_URL => 'https://api.fonnte.com/send',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => ['target' => $target,'message' => HEADER_MESSAGE.str_replace(["https://","/","//","http://"],['','','',''],$message).FOOTER_MESSAGE,'url' => $urlFile,'filename' => $fileName],
              CURLOPT_HTTPHEADER => ['Authorization: '.TOKEN_API_FONNTE],
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            $status = json_decode($response, TRUE);
            if($status['status']==true){
                $result = true;
            }
        }
        return $result;
    }
            
    public static function getDeviceQr()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/qr',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: '.TOKEN_API_FONNTE
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response, TRUE);
        $result = false;
        if($status['status']==true){
            $result = '<img src="data:image/png;base64,'.$status['url'].'" width="10%">';
        }
        return $result;
    }
    
    public static function validatePhone($target)
    {
        $stsDevice = self::deviceStatus();
        $result = false;
        if($stsDevice==true){
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.fonnte.com/validate',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_SSL_VERIFYPEER => false,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('target' => $target,'countryCode' => '62'),
              CURLOPT_HTTPHEADER => array(
                'Authorization: '.TOKEN_API_FONNTE
              ),
            ));
            $response = curl_exec($curl);
            $status = json_decode($response, TRUE);
            if($status['status']==true){
                if($status['device_status']=='connect'){
                    $result = true;
                }
            }
        }
        return $result;
    }
        
    public static function getListGroup()
    {
        self::updateGroup();
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/get-whatsapp-group',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: '.TOKEN_API_FONNTE
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response, TRUE);
        $result = [];
        if($status['status']==true)        {
            $result = $status['data'];
        }
        return $result;
    }
        
    public static function deviceProfile()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/device',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: '.TOKEN_API_FONNTE
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response, TRUE);
        return $status;
    }
    
    /**
     * For Update List WhatsApp Goup
    **/
    private static function updateGroup()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/fetch-group',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: '.TOKEN_API_FONNTE
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
    
    /**
     * For Check Status Device
    **/
    private static function deviceStatus()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/device',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: '.TOKEN_API_FONNTE
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response, TRUE);
        $result = false;
        if($status['status']==true){
            if($status['device_status']=='connect'){
                $result = true;
            }
        }
        return $result;
    }
}
?>
