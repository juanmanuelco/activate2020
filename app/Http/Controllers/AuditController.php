<?php

namespace App\Http\Controllers;

use App\Repositories\AuditRepository;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{
    private AuditRepository $auditRepository;

    /**
     * AuditController constructor.
     * @param AuditRepository $auditRepo
     */
    public function __construct(AuditRepository $auditRepo)
    {
        $this->auditRepository = $auditRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $audit_log = $this->auditRepository;
        $audit_log = $audit_log->search(isset($request['search'])? $request['search'] : '');
        $audit_log = $audit_log->paginate(30);
        return view('pages.audit.index')->with('audits', $audit_log);
    }
}
