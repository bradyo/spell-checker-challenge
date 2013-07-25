<?php
require_once('bootstrap.php');

// Run all tests manually since we aren't using a test framework

// Run checker tests
$checkerTest = new CheckerTest();
echo "Testing Checker...";
$checkerTest->testGetSuggestion();
echo " passed!\n";

// Run typo generator tests
$typoGeneratorTest = new TypoGeneratorTest();
echo "Testing TypoGenerator...";
$typoGeneratorTest->testGenerateWord();
echo " passed!\n";

echo "Tests passed";
