<?php

namespace App\Http\Controllers;

use Facade\FlareClient\View;
use Illuminate\Http\Request;
use App\Helpers\CategoryRecursive;

class AccountController extends Controller
{
    private $categoryRecursive;

    public function __construct(CategoryRecursive $categoryRecursive)
    {
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index()
    {
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse]
            = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        return
            View(
                'client.account.index',
                compact(
                    'megaMenuHeader',
                    'menuResponse',
                )
            );
    }
}
