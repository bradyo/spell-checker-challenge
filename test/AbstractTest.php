<?php

abstract class AbstractTest
{
    protected function assertEquals($a, $b) {
        if ($a != $b) {
            throw new Exception();
        }
    }
}