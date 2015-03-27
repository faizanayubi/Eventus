<?php

/**
 * Description of home
 *
 * @author Faizan Ayubi
 */
use Framework\Controller as Controller;

class Home extends Controller {

    function index() {
        $view = $this->getActionView();
    }

}
