<?php
/**
 * Standard about view controller
 *
 * @class              WPXCleanFixAboutViewController
 * @author             =undo= <info@wpxtre.me>
 * @copyright          Copyright (C) 2012-2013 wpXtreme Inc. All Rights Reserved.
 * @date               2013-02-21
 * @version            1.1.1
 *
 */

class WPXCleanFixAboutViewController extends WPXAboutViewController {

  /**
   * Create an instance of WPXCleanFixAboutViewController class
   *
   * @brief Construct
   *
   * @return WPXCleanFixAboutViewController
   */
  public function __construct() {
    parent::__construct( $GLOBALS['WPXCleanFix'] );
  }
}