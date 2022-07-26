<?php


namespace App\Http\Services;




use App\Enums\Status;
use App\Models\Backend\SmsSetting;

class SmsService
{
    public function sendOtp($userPhone,$otpCode)
    {
        try {
            $smsSetting                 = SmsSetting::where('status',Status::ACTIVE)->first();
            if(!blank($smsSetting)){
                $api_key                = $smsSetting->api_key;
                $api_secret             = $smsSetting->secret_key;
                $api_url                = $smsSetting->api_url;
                $callerID               = 'wemax it';
                $msg                    = $otpCode.' is your '.settings()->name.' verification code.';


                $params = [
                    "apikey"            => $api_key,
                    "secretkey"         => $api_secret,
                    "callerID"          => $callerID,
                    "toUser"            => $userPhone,
                    "messageContent"    => $msg
                ];

                $url = $api_url . '?' . http_build_query($params);
                $ch                     = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);

                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }

            return true;
        }catch (\Exception $exception){
            return $exception;
        }


    }

    public function sendSms($userPhone,$msg)
    {
        try {
            $smsSetting                 = SmsSetting::where('status',Status::ACTIVE)->first();
            if(!blank($smsSetting)){
                $api_key                = $smsSetting->api_key;
                $api_secret             = $smsSetting->secret_key;
                $api_url                = $smsSetting->api_url;
                $callerID               = 'wemax it';


                $params = [
                    "apikey"            => $api_key,
                    "secretkey"         => $api_secret,
                    "callerID"          => $callerID,
                    "toUser"            => $userPhone,
                    "messageContent"    => $msg
                ];

                $url = $api_url . '?' . http_build_query($params);
                $ch                     = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);

                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }

            return true;
        }catch (\Exception $exception){
            return $exception;
        }


    }


}
