<?php

class CheckerTest extends AbstractTest
{
    public function testGetSuggestion() {
        // Initialize checker with test dictionary words
        $dictionary = new Dictionary(array(
            'sandwich',
            'inside',
            'job',
            'sheep',
            'hoop',
            'people',
            'wake',
            'conspiracy',
            'food'
        ));
        $checker = new Checker($dictionary);
        
        // Check that dictionary words resolve
        $suggestion = $checker->getSuggestion('sandwich');
        $this->assertEquals('sandwich', $suggestion);
        
        // Check that incorrect casing resolves
        $suggestion = $checker->getSuggestion('inSIDE');
        $this->assertEquals('inside', $suggestion);
        
        // Check that repeats resolve
        $suggestion = $checker->getSuggestion('jjoobbb');
        $this->assertEquals('job', $suggestion);
        
        $suggestion = $checker->getSuggestion('sheeeeep');
        $this->assertEquals('sheep', $suggestion);
        
        $suggestion = $checker->getSuggestion('hooop');
        $this->assertEquals('hoop', $suggestion);

        // Check that incorrect vowels resolve
        $suggestion = $checker->getSuggestion('weke');
        $this->assertEquals('wake', $suggestion);
        
        // Check that combination typos resolve
        $suggestion = $checker->getSuggestion('peepple');
        $this->assertEquals('people', $suggestion);
        
        $suggestion = $checker->getSuggestion('CUNsperrICY');
        $this->assertEquals('conspiracy', $suggestion);
        
        $suggestion = $checker->getSuggestion('ffoaoaoaoaoaoaaoaoaoaoaoadd');
        $this->assertEquals('food', $suggestion);
        
        // Check that word without suggestion is null
        $suggestion = $checker->getSuggestion('sheeple');
        $this->assertEquals(null, $suggestion);
    }
}
