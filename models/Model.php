<?php

interface Model 
{
  public static function from_array ($arr);
  public static function find_by_id ($id);
}