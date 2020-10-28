<?php
/**
 * alike_is_homogenous
 *
 * @param array
 * @return bool
 */
function alike_is_homogenous( $arr ) {
  $firstValue = current( $arr );
  foreach ( $arr as $val ) {
    if ( $firstValue !== $val ) {
      return false;
    }
  }

  return true;
}
