<?php
declare(strict_types=1);

/** @namespace */
namespace App\Http\Controllers\Mailing;

/** @uses */
use App\Http\Controllers\Controller;
use App\Services\MailingManager;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ListMailingTasks
 * @package App\Http\Controllers\Mailing
 */
class ListMailingTasks extends Controller
{
    /** @var MailingManager */
    private $mailingManager;

    /**
     * ListMailingTasks constructor.
     *
     * @param MailingManager $mailingManager
     */
    public function __construct(MailingManager $mailingManager)
    {
        $this->mailingManager = $mailingManager;
    }

    /**
     * Handle the incoming request.
     *
     * @param  Request $request
     *
     * @return View
     */
    public function __invoke(Request $request): View
    {
        $tasks = $this->mailingManager->retrieveAllPaginatedTasks();

        return view('mailing.list', compact('tasks'));
    }
}
