<?php

function currency($expression) {
    return "Rp. " . number_format($expression,0,',','.');
}