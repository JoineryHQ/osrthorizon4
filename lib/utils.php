<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Utility methods for osrthorizon
 *
 * @author as
 */
class OsrthorizonUtils {
  public static function normalizeSectionHeaderLink($str) {
    $ret = strtolower(preg_replace('/[^0-9a-zA-Z]/', '-', trim($str)));
    return $ret;
  }

}
