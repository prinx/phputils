<?php

/*
 * This file is part of the PHPUtils package.
 *
 * (c) Prince Dorcis <princedorcis@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prinx\Utils;

/**
 * SMS utilities class.
 *
 * @author Prince Dorcis <princedorcis@gmail.com>
 */
class SMS
{
    public static $maxSmsContent = 139;

    public function send(array $data, array $requiredParams = [], $silent = false)
    {
        $requiredParams = empty($requiredParams) ?
        ['message', 'recipient', 'sender', 'endpoint'] :
        $requiredParams;

        try {
            foreach ($requiredParams as $param) {
                if (!isset($data[$param])) {
                    throw new \Exception('"sendSms" function requires parameter "'.$param.'".');
                }
            }

            $smsData = [
                'message'   => '',
                'recipient' => $data['recipient'],
                'sender'    => $data['sender'],
            ];

            $msgChunks = self::makeSmsChunks($data['message']);

            $response = [];

            foreach ($msgChunks as $message) {
                $smsData['message'] = $message;
                $response[] = HTTP::post($smsData, $data['endpoint'], 'Sending SMS');
            }

            if ($silent) {
                return ['SUCCESS' => 'unknown'];
            }

            $successAll = true;
            $failedAll = true;

            $result = ['SUCCESS' => true];

            foreach ($response as $value) {
                if (!$value['SUCCESS']) {
                    $successAll = false;
                    $result['SUCCESS'] = false;

                    if (!isset($result['errors'])) {
                        $result['errors'] = [];
                    }

                    $result['errors'][] = $value['error'];
                } else {
                    $failedAll = false;
                }
            }

            if ($successAll) {
                $result['message'] = 'Message(s) delivered successfuly';
            } elseif ($failedAll) {
                $result['message'] = 'All message(s) delivery failed';
            } else {
                $result['message'] = 'Some messages delivery failed';
            }

            return $result;
        } catch (\Exception $e) {
            exit('An error happens while sending SMS: '.$e->getMessage());
        }
    }

    public static function makeSmsChunks($msg)
    {
        if (strlen($msg) > self::$maxSmsContent) {
            $continued = '...';
            $messageChunks = str_split($msg, self::$maxSmsContent - strlen($continued));

            $last = count($messageChunks) - 1;

            foreach ($messageChunks as $index => $chunk) {
                if ($index !== $last) {
                    $messageChunks[$index] = $chunk.$continued;
                }
            }

            return $messageChunks;
        }

        return [$msg];
    }
}
