<?php

/**
 * Checker finds spelling suggestions for mis-typed words based on dictionary
 * words.
 * 
 * Checker corrects the following three types of spelling mistakes:
 * 1. Case (upper/lower) errors:  "inSIDE" -> "inside"
 * 2. Repeated letters:  "jjoobbb" -> "job"
 * 3. Incorrect vowels:  "weke" -> "wake"
 */
class Checker
{
    private $dictionary;
    
    public function __construct(Dictionary $dictionary) {
        $this->dictionary = $dictionary;
    }

    /**
     * Finds the closest matching dictionary word for a given word
     * 
     * @param string $word
     * @return string|null The closest maching dictionary word or null if none found
     */
    public function getSuggestion($word) {
        return $this->findCollapsedSuggestion($word);
    }
    
    /**
     * Collapse repeat in word and find suggestion on each collapsed word in
     * a breadth-first way so that suggestion will be closest to original string
     * 
     * @param type $word
     * @return string|null suggested word or null if none found
     */
    public function findCollapsedSuggestion($word) {
        // If word has a suggestion without collapsing repeats, return it
        $suggestion = $this->findSuggestion($word);
        if ($suggestion !== null) {
            return $suggestion;
        }
        
        // Get all words with one repeat removed
        $collapsedWords = $this->getCollapsedWords($word);
        if (count($collapsedWords) === 0) {
            return null;
        }
        
        // Try to find a suggestion for each new word
        foreach ($collapsedWords as $collapsedWord) {
            $suggestion = $this->findCollapsedSuggestion($collapsedWord);
            if ($suggestion !== null) {
                return $suggestion;
            }
        }
        return null;
    }
    
    /**
     * Finds a suggestion by fixing casing and mis-spellings
     * 
     * @param string $word
     * @return string|null The closest maching dictionary word or null if none found
     */
    private function findSuggestion($word) {
        // Return word if it's a dictionary word
        if ($this->dictionary->hasWord($word)) {
            return $word;
        }
        
        // Return word if lowercased word is in dictionary
        $lowercaseWord = strtolower($word);
        if ($this->dictionary->hasWord($lowercaseWord)) {
            return $lowercaseWord;
        }
        
        // Return any close dictionary words based on mis-spellings
        $closestWord = null;
        $minCount = null;
        $possibleWords = $this->dictionary->getConsonantMatchedWords($word);
        foreach ($possibleWords as $possibleWord) {
            $count = $this->getReplacementCount($word, $possibleWord);
            if ($minCount === null || $count < $minCount) {
                $closestWord = $possibleWord;
                $minCount = $count;
            }
        }
        return $closestWord;
    }
    
    /**
     * Gets the number of character replacements required to turn a into b
     * @param string $a
     * @param string $b
     * @return int
     */
    private function getReplacementCount($a, $b) {
        $count = 0;
        $length = strlen($a);
        for ($i = 0; $i < $length; $i++) {
            $aChar = substr($a, $i, 1);
            $bChar = substr($b, $i, 1);
            if ($aChar !== $bChar) {
                $count++;
            }
        }
        return $count;
    }
    
    /**
     * Gets an array of all words with one repeat sequence removed from given word
     * @param string $word
     * @return array
     */
    public function getCollapsedWords($word) {
        // Find short tandem repeat sequences in string
        $matches = array();
        preg_match_all('/(.{1,2}?)\1+/', $word, $matches);
        if ($matches === FALSE) {
            return array();
        }
        
        // Collect words with one repeat removed
        $collapsedWords = array();
        $numMatches = count($matches[0]);
        for ($i = 0; $i < $numMatches; $i++) {
            $rangeSequence = $matches[0][$i];
            $repeatSequence = $matches[1][$i];
            
            // find all occurances of range sequence in word
            $rangePos = 0;
            while (($rangePos = strpos($word, $rangeSequence, $rangePos)) !== FALSE) {
                // Remove first repeat sequence and add to collaped words
                $endLeft = $rangePos + strlen($repeatSequence);
                $endRight = strlen($word);
                $collapsedWord = substr($word, 0, $rangePos)
                    . substr($word, $endLeft, $endRight);
                $collapsedWords[] = $collapsedWord;
                
                $rangePos += strlen($rangeSequence);
            }
        }
        return $collapsedWords;
    }
    
}
