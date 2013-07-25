<?php

/**
 * Dictionary holds list of dictionary words and allows looking up words by
 * consonant strings.
 */
class Dictionary 
{
    private $wordsMap = array();
    private $wordsByConsonantKey = array();
    
    /**
     * @param array $words array of words to initialize with
     */
    public function __construct(array $words) {
        foreach ($words as $word) {
            // Normalize input
            $word = trim($word);
            
            // Build a hash map for looking up words
            $this->wordsMap[$word] = true;
            
            // Build a map of words indexed by consonant key (vowels removed)
            $consonantKey = $this->getConsonantKey($word);
            if (!isset($this->wordsByConsonantKey[$consonantKey])) {
                $this->wordsByConsonantKey[$consonantKey] = array();
            }
            $this->wordsByConsonantKey[$consonantKey][] = $word;
        }
    }
    
    /**
     * 
     * @param type $word
     * @return type
     */
    private function getConsonantKey($word) {
        $vowels = array('a', 'e', 'i', 'o', 'u');
        return strtolower(str_ireplace($vowels, '', $word));
    }
    
    /**
     * Checks if a word exists in the dictionary
     * @param string $word 
     * @return boolean true if the word exists
     */
    public function hasWord($word) {
        return isset($this->wordsMap[$word]);
    }
     
    /**
     * Get words in the dictionary that match consonants and have the same
     * length as given word
     * 
     * @param string $word
     * @return array
     */
    public function getConsonantMatchedWords($word) {
        // Subset dicitonary words where consonants match
        $possibleWords = array();
        $consonantKey = $this->getConsonantKey($word);
        if (isset($this->wordsByConsonantKey[$consonantKey])) {
            $possibleWords = $this->wordsByConsonantKey[$consonantKey];
        }
        
        // Only keep words where consonants line up (vowel spacing is same)
        $matchedWords = array();
        foreach ($possibleWords as $foundWord) {
           if ($this->isConsonantMatched($word, $foundWord)) {
               $matchedWords[] = $foundWord;
           }
        }
        return $matchedWords;
    }
    
    /**
     * Checks if consonants line up between two strings
     * 
     * @param string $a
     * @param string $b
     * @return boolean true if consonants match
     */
    private function isConsonantMatched($a, $b) {
        if (strlen($a) !== strlen($b)) {
            return false;
        }
        $length = strlen($a);
        $vowels = array('a','e','i','o','u');
        for ($i = 0; $i < $length; $i++) {
            $aChar = strtolower(substr($a, $i, 1));
            $bChar = strtolower(substr($b, $i, 1));
            $isConsonant = ! in_array($aChar, $vowels);
            if ($isConsonant && $aChar !== $bChar) {
                return false;
            }
        }
        return true;
    }
}
