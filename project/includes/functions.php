<?php
// FUNCTIONS

function formatDate($originalDate, $formattedDate){
   $originalDate = new DateTime($originalDate);
   $formattedDate = $originalDate->format('d/m/Y');
   return $formattedDate;
}

// register form = see password 2 + prevent copy paste + check that pw2 = pw1
