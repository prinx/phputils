<?php
namespace Prinx\Utils;

class HTTP
{
    public static function post($postvars, $endpoint, $request_description = '')
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $endpoint);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl_handle);
        $err = curl_error($curl_handle);
        curl_close($curl_handle);

        if ($err) {
            $description = '';

            if ($request_description) {
                $description = '<br/><span style="color:red;">ERROR POST REQUEST:</span> ' . $request_description . '<br/>';
            }

            return [
                'SUCCESS' => false,
                'error' => $description . $err,
            ];
        } else {
            return [
                'SUCCESS' => true,
                'data' => $result,
            ];
        }
    }
}
