<?php

namespace PhpBotFramework\Core;

trait Updates {

    abstract protected function exec_curl_request($url, $method);

    /**
     * \addtogroup Api Api Methods
     * @{
     */

    /**
     * \brief Set bot's webhook.
     * \details Set a webhook for the current bot in order to receive incoming
     * updates via an outgoing webhook.
     * @param $params See [Telegram API](https://core.telegram.org/bots/api#setwebhook)
     * for more information about the available parameters.
     */
    public function setWebhook(array $params) {

        return $this->exec_curl_request('setWebhook?' . http_build_query($params));

    }

    /**
     * \brief Get information about bot's webhook.
     * \details Returns an hash which contains information about bot's webhook.
     */
    public function getWebhookInfo() {

        return $this->exec_curl_request('getWebhookInfo');

    }

    /**
     * \brief Delete bot's webhook.
     * \details Delete bot's webhook if it exists.
     */
    public function deleteWebhook() {

        return $this->exec_curl_request('deleteWebhook');

    }

    /**
     * \brief Request bot updates.
     * \details Request updates received by the bot using method getUpdates of Telegram API. [Api reference](https://core.telegram.org/bots/api#getupdates)
     * @param $offset <i>Optional</i>. Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id. The negative offset can be specified to retrieve updates starting from -offset update from the end of the updates queue. All previous updates will forgotten.
     * @param $limit <i>Optional</i>. Limits the number of updates to be retrieved. Values between 1—100 are accepted.
     * @param $timeout <i>Optional</i>. Timeout in seconds for long polling.
     * @return Array of updates (can be empty).
     */
    public function getUpdates(int $offset = 0, int $limit = 100, int $timeout = 60) {

        $parameters = [
            'offset' => $offset,
            'limit' => $limit,
            'timeout' => $timeout,
        ];

        return $this->exec_curl_request('getUpdates?' . http_build_query($parameters));

    }

    /**
     * \brief Set updates received by the bot for getUpdates handling.
     * \details List the types of updates you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. Specify an empty list to receive all updates regardless of type.
     * Set it one time and it won't change until next setUpdateReturned call.
     * @param $allowed_updates <i>Optional</i>. List of updates allowed.
     */
    public function setUpdateReturned(array $allowed_updates = []) {

        // Parameter for getUpdates
        $parameters = [
            'offset' => 0,
            'limit' => 1,
            'timeout' => 0,
        ];

        // Exec getUpdates
        $this->exec_curl_request('getUpdates?' . http_build_query($parameters)
                                               . '&allowed_updates=' . json_encode($allowed_updates));

    }

    /** @} */

}