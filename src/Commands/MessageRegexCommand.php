<?php

namespace PhpBotFramework\Commands;

use PhpBotFramework\Entities\Message;

trait MessageRegexCommand {

    /**
     * \addtogroup Commands
     * \brief What commands are
     * @{
     */

    /** \brief (<i>Internal</i>)Store the command triggered on message. */
    protected $_message_regex_commands;

    /**
     * \brief Add a function that will be executed everytime a message contain a command that match the regex
     * \details Use this syntax:
     *
     *     addMessageCommandRegex("number\d", function($bot, $message, $result) {
     *         $bot->sendMessage("You sent me a number"); });
     * @param $regex_rule Regex rule that will called for evalueting the command received.
     * @param $script The function that will be triggered by a command. Must take an object(the bot) and an array(the message received).
     */
    public function addMessageCommandRegex(string $regex_rule, callable $script) {

        $this->_message_commands[] = [
            'script' => $script,
            'regex_rule' => $regex_rule
        ];

    }

    /**
     * \brief (<i>Internal</i>) Process the message to check if it triggers a command of this type.
     * @param $message Message to process.
     * @return True if the message triggered a command.
     */
    protected function processMessageRegexCommand(array $message) : bool {

        // and there are bot commands in the message, checking message entities
        if (isset($message['entities']) && $message['entities'][0]['type'] === 'bot_command') {

            // For each command added by the user
            foreach ($this->_message_commands as $trigger) {

                // Use preg_match to check if it is true
                if (preg_match("/{$trigger['regex_rule']}/", substr($message['text'], $message['entities'][0]['offset'] + 1, $message['entities'][0]['length']))) {

                    $this->_chat_id = $message['chat']['id'];

                    // Trigger the script
                    $trigger['script']($this, new Message($message));

                    // The message triggered a command, return true
                    return true;

                }

            }

        }

        // No command were triggered
        return false;

    }

}