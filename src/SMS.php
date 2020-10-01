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
    public static $max_sms_content = 139;

    public function send(array $data, array $required_params = [], $silent = false)
    {
        $required_params = empty($required_params) ?
        ['message', 'recipient', 'sender', 'endpoint'] :
        $required_params;

        try {
            foreach ($required_params as $param) {
                if (!isset($data[$param])) {
                    throw new \Exception('"send_sms" function requires parameter "'.$param.'".');
                }
            }

            $sms_data = [
                'message'   => '',
                'recipient' => $data['recipient'],
                'sender'    => $data['sender'],
            ];

            $msg_chunks = self::makeSmsChunks($data['message']);

            $response = [];

            foreach ($msg_chunks as $message) {
                $sms_data['message'] = $message;
                $response[] = HTTP::post($sms_data, $data['endpoint'], 'Sending SMS');
            }

            if ($silent) {
                return ['SUCCESS' => 'unknown'];
            }

            $success_all = true;
            $failed_all = true;

            $result = ['SUCCESS' => true];

            foreach ($response as $value) {
                if (!$value['SUCCESS']) {
                    $success_all = false;
                    $result['SUCCESS'] = false;

                    if (!isset($result['errors'])) {
                        $result['errors'] = [];
                    }

                    $result['errors'][] = $value['error'];
                } else {
                    $failed_all = false;
                }
            }

            if ($success_all) {
                $result['message'] = 'Message(s) delivered successfuly';
            } elseif ($failed_all) {
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
        if (strlen($msg) > self::$max_sms_content) {
            $continued = '...';
            $message_chunks = str_split($msg, self::$max_sms_content - strlen($continued));

            $last = count($message_chunks) - 1;

            foreach ($message_chunks as $index => $chunk) {
                if ($index !== $last) {
                    $message_chunks[$index] = $chunk.$continued;
                }
            }

            return $message_chunks;
        }

        return [$msg];
    }
}
