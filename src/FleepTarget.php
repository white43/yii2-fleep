<?php

namespace white43\Fleep;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\log\Target;

/**
 * Class FleepTarget
 * @package white43\Fleep
 */
class FleepTarget extends Target
{
    /**
     * @var string
     */
    public $hook = null;

    /**
     * @var string
     */
    public $endpoint = 'https://fleep.io/hook/';

    /**
     * FleepTarget constructor.
     * @param array $config
     * @throws InvalidConfigException
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        if (!isset($this->hook) || !is_string($this->hook) || strlen($this->hook) === 0) {
            throw new InvalidConfigException;
        }
    }

    /**
     * Exports log [[messages]] to a specific destination.
     * Child classes must implement this method.
     */
    public function export()
    {
        $ch = curl_init();
        $message = implode("\n", array_map([$this, 'formatMessage'], $this->messages));

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->endpoint . $this->hook,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Expect:',
                'Content-type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'message' => $message,
            ]),
        ]);

        $response = curl_exec($ch);

        try {
            if ($response !== false) {
                $http_code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($http_code !== 200) {
                    throw new Exception($response, $http_code);
                }
            } else {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        } finally {
            curl_close($ch);
        }
    }

    /**
     * Formats a log message for display as a string.
     * @param array $message the log message to be formatted.
     * The message structure follows that in [[Logger::messages]].
     * @return string the formatted message
     */
    public function formatMessage($message)
    {
        return ":::\n" . parent::formatMessage($message) . "\n:::";
    }
}
