<?php

namespace PhpBotFramework\Localization;

trait File {

    /**
     * \addtogroup Localization Localization
     * \brief Methods to create a localized bot.
     * \details Localization files must have this syntax:
     * file <code>./localization/en.json</code>:
     *
     *     {"Hello_Msg": "Hello"}
     *
     * File <code>./localization/it.json</code>:
     *
     *     {"Hello_Msg": "Ciao"}
     *
     * Usage in <code>processMessage()</code>:
     *
     *     $sendMessage($this->local[$this->language]["Hello_Msg"]);
     *
     * @{
     */

    /** \brief Store the localizated strings. */
    protected $local;

    /** \brief Directory where there are the localization files. */
    protected $localization_dir = './localization';

    /**
     * \brief Load a localization file into the localized strings array.
     * @param $lang Language to load.
     * @param $dir Directory in which there are the JSON files.
     * @return True if loaded. False if already loaded.
     */
    protected function loadSingleLanguage(string $lang = 'en', $dir = './localization') : bool {

        // Name of the file
        $filename = "$dir/$lang";

        // If this language isn't already set and the file exists
        if (!isset($this->local[$lang]) && file_exists($filename)) {

            // Load localization in memory
            $this->local[$lang] = json_decode(file_get_contents($filename), true);

            // We loaded it
            return true;

        }

        return false;

    }

    /**
     * \brief Load all localization files (JSON-serialized) from a folder and set them in $local variable.
     * \details Save all localization files, saved as json format, from a directory and put the contents in $local variable.
     * Each file will be saved into $local with the first two letters of the filename as the index.
     * @param $dir Directory where the localization files are saved.
     */
    public function loadLocalization($dir = './localization') {

        // Open directory
        if ($handle = opendir($dir)) {

            // Iterate over all files
            while (false !== ($file = readdir($handle))) {

                // If the file is a JSON data file
                if (strlen($file) > 6 && substr($file, -5) === '.json') {

                    try {

                        // Add the contents of the file to the $local variable, after deserializng it from JSON format
                        // The contents will be added with the 2 letter of the file as the index
                        $this->local[substr($file, 0, 2)] = json_decode(file_get_contents("$dir/$file"), true);

                    } catch (BotException $e) {

                        echo $e->getMessage();

                    }

                }

            }

        }

    }

    public function setLocalizationDir($dir) {

        $this->localization_dir = $dir;

    }

    /** @} */

}