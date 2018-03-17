<?php

namespace App\Controllers;

use Core\View;
use App\Models\Customer;
use Core\Controller;

/**
 * Class Home
 * @package App\Controllers
 */
class Home extends Controller
{
    /**
     * Shows the index page
     */
    public function indexAction()
    {
        View::renderTemplate('home/index.twig');
    }
}
