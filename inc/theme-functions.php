<?php
/**
* Theme functions & bits
*
* @package Cautious_Octo_Fiesta
*/

 
/**
 * helper functions used for competition teases meta data 
 *
**/

function days_left($date) {
  $date1 = new DateTime('now');
  $date2 = new DateTime($date);
  $days  = $date2->diff($date1)->format('%a');
  return $days;
}
function hours_left($date) {
  $date1 = new DateTime('now');
  $date2 = new DateTime($date);
  $days  = $date2->diff($date1)->format('%h');
  return $days;
}
function time_left($date) {
  $current_time = current_time('timestamp');
  $whats_left_in_human = human_time_diff($date, $current_time);
  
  return $whats_left_in_human;
}
function tickets_left($max_tickets, $participants_count) {
  $tickets_left = $max_tickets - $participants_count;
  return $tickets_left;
}