<?php
/**
 * @filename: SidebarComposer.php
 */
declare(strict_types=1);

/** @namespace */
namespace App\View\Composer\Navigation;

/** @uses */
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SidebarComposer
 * @package App\View\Composer\Navigation
 */
class SidebarComposer
{
    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $navigation = array_map(function ($item) {
            $url = route($item['route']);
            $active = $url === $this->request->url();

            return new NavigationItem(
                $item['title'], $url, $active
            );
        }, config('navigation'));

        $view->with('navigation', $navigation);
    }
}