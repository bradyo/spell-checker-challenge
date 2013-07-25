<?php

/**
 * Generates mis-spelled words based on dictionary words.
 */
class TypoGenerator
{
    private $dictionary;
    
    /**
     * @param Dictionary $dictionary Dictionary to generate mis-spellings from
     */
    public function __construct(Dictionary $dictionary) {
        $this->dictionary = $dictionary;
    }
    
    /**
     * Generate a random misspelled word based on a dictionary word
     * @return string
     */
    public function generate() {
        throw new Exception('Not Implemented');
    }
}
