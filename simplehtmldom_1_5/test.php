<?php
$re = '/^.*?teamId=(\d+).*$/';
$str = '/ffl/clubhouse?leagueId=347987&teamId=15&seasonId=2015';

preg_match_all($re, $str, $matches);

// Print the entire match result
print_r($matches);

?>