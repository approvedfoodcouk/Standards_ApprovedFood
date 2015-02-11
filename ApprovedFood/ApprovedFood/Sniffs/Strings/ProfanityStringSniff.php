<?php
class ApprovedFood_Sniffs_Strings_ProfanityStringSniff implements PHP_CodeSniffer_Sniff {
    private static $dictionary;
    public function register()
    {
        return array(T_OPEN_TAG);
    }
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($stackPtr > 0 && $phpcsFile->findPrevious(T_OPEN_TAG, $stackPtr - 1) !== false) {
            return; // not first open tag in this file
        }

        self::initDictionary();
        foreach ($phpcsFile->getTokens() as $stackPtr => $token) {
            if (!isset($token['content'])) {
                continue;
            }

            if (!preg_match_all('/\b\w+\b/', trim($token['content']), $match)) {
                continue;
            }

            foreach ($match[0] as $wordGroup) {
                $words = preg_split('/(?<=[a-z])(?=[A-Z])/', $wordGroup);
                foreach ($words as $word) {
                    $word = strtolower($word);
                    if (isset(self::$dictionary[$word])) {
                        $phpcsFile->addWarning("Found bad word '".$word."'", $stackPtr, 'Profanity');
                    }
                }
            }
        }
    }
    /**
     * Load dictionaries from disk
     */
    private static function initDictionary()
    {
        if (self::$dictionary !== NULL) return;
        $d = array();
        foreach (glob(__DIR__ . '/dicts/profanity.dic') as $file) {
            foreach (file($file) as $line) {
                if ($word = trim($line)) $d[] = $word;
            }
        }
        self::$dictionary = array_flip($d);
    }
}
