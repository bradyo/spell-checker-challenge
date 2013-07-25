<?php
require_once 'bootstrap.php';

// Initialize checker with dictionary words from file
$words = file('data/english.dict');
$dictionary = new Dictionary($words);
$checker = new Checker($dictionary);

// Read lines from stdin and output the best spelling suggestion
while(true) {
    $line = readline('>');
    $input = trim($line);
    $suggestion = $checker->getSuggestion($input);
    if ($suggestion !== null) {
        echo $suggestion, "\n";
    } else {
        echo "NO SUGGESTION\n";
    }
}
