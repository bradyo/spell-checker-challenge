<?php

class TypoGeneratorTest extends AbstractTest
{
    public function testGenerateWord() {
        // Initialize checker and generator with test dictionary
        $dictionary = new Dictionary(array(
            'sandwich',
            'inside',
            'job',
            'sheep',
            'people',
            'wake',
            'consipracy',
            'food'
        ));
        $checker = new Checker($dictionary);
        $typoGenerator = new TypoGenerator($dictionary);
        
        // Check that none of the generated words have no suggestions
        $sampleSize = 100;
        $noSuggestionCount = 0;
        for ($i = 0; $i < $sampleSize; $i++) {
            $word = $typoGenerator->generateWord();
            $suggestion = $checker->getSuggestion($word);
            if ($suggestion === null) {
                $noSuggestionCount++;
            }
        }
        $this->assertEquals(0, $noSuggestionCount);
    }
}
