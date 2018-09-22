<?php
declare(strict_types=1);

/** @namespace */
namespace App\Http\Controllers\Mailing;

/** @uses */
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessMailingRequest;
use App\Services\MailingManager;
use Illuminate\Http\RedirectResponse;

/**
 * Class ProcessMailing
 * @package App\Http\Controllers\Mailing
 */
class ProcessMailing extends Controller
{
    /** @var MailingManager */
    private $mailingManager;

    /**
     * ProcessMailing constructor.
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
     * @param ProcessMailingRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ProcessMailingRequest $request): RedirectResponse
    {
        $this->mailingManager->processNewTask($request);

        return redirect()->back()
                         ->with('message', trans('Task successfully created'));
    }
}
