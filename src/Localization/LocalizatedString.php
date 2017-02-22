<?php

/*
 * This file is part of the PhpBotFramework.
 *
 * PhpBotFramework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, version 3.
 *
 * PhpBotFramework is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace PhpBotFramework\Localization;

/**
 * \addtogroup Modules
 * @{
 */

/** \class LocalizatedString
 */
trait LocalizatedString
{

    /** @} */

    /**
     * \addtogroup Localization Localization
     * @{
     */

    /**
     * \brief Returns the requested string in the user's language.
     * \details It uses framework's multi-language features to show the requested string in the user's language.
     * @param string $index The name for the requested string (e.g. Welcome_Msg)
     * @return string The requested string in the right language.
     */
    public function getStr($index)
    {

        if (!isset($this->language)) {
            throw BotException("Language not set");
        }

        // If the language of the user is already set in the array containing localizated strings
        if (!isset($this->local[$this->language])) {
            if (isset($this->webhook)) {
                $this->loadSingleLanguage($this->localization_dir);
            } else {
                $this->loadLocalization($this->localization_dir);
            }
        }

        // Check if the requested string exists
        if (isset($this->local[$this->language][$index])) {
            return $this->local[$this->language][$index];
        }

        throw BotException("$index is not set for {$this->language}");
    }

    /** @} */
}
