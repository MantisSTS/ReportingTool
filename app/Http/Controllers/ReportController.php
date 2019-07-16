<?php

namespace App\Http\Controllers;

use Storage;
use App\User;
use App\Client;
use App\Report;
use App\Vulnerability;
use App\Phase;
use App\Assessment;
use App\ReportVulnerability;
use App\Helpers\PHPWordHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public function addVulnsToReport(Request $request) 
    {
        $reportId = $request->report_id;
        $vulns = $request->vuln_ids;
        $added = 0;

        if(!empty($vulns) && is_array($vulns)) {
            foreach($vulns as $vuln) {
                $vulnObj = new ReportVulnerability;
                $vulnObj->report_id = $reportId;
                $vulnObj->user_id = Auth::id();
                $vulnObj->vuln_id = $vuln;
                $vulnObj->client_id = 0; // This should be associated with the report_id
                if($vulnObj->save()) {
                    $added++;
                }
            }
        }
        $issues = $this->getReportVulns($reportId);
        return response()->json(['report_id' => $reportId, 'vulns' => $issues]);
    }

    public function getReportVulns($reportId) 
    {
        // @TODO: Maybe only 'select' the fields that are required
        $data = DB::table('report_vulnerabilities')
            ->leftJoin('vulnerabilities', 'vulnerabilities.id', '=', 'report_vulnerabilities.vuln_id')
            ->select('vulnerabilities.*')
            ->get();
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = DB::table('reports')
            ->leftJoin('report_status', 'reports.status_id', '=', 'report_status.id')
            ->leftJoin('assessments', 'assessments.id', '=', 'reports.assessment_id')
            ->leftJoin('phases', 'phases.report_id', '=', 'reports.id')
            ->leftJoin('clients', 'reports.client_id', '=', 'clients.id')
            ->leftJoin('users', 'users.id', '=', 'reports.author_id')
            ->select('reports.id', DB::raw('COUNT(phases.id) as phase_count'), 'assessments.id as assessment_id', 'report_status.status', 'clients.id as client_id', 'clients.name', 'users.first_name', 'users.last_name', 'assessments.name AS assessment_name')
            ->groupBy('reports.id')
            ->orderBy('reports.updated_at')
            ->get();
        return view('report.home')->with(['reports' => $reports]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::select('id', 'name')->get();
        return view('report.new_report')->with(['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    protected function getReportDetails(int $reportId) 
    {
        return DB::table('reports')
            ->leftJoin('assessments', 'assessments.id', '=', 'reports.assessment_id')
            ->leftJoin('phases', 'phases.report_id', '=', 'reports.id')
            ->select('reports.*', 'phases.name AS phase_name', 'assessments.name AS assessment_name', 'reports.author_id as author_id')
            ->where('reports.id', '=', $reportId)
            ->first();

    }


    protected function getClientsDetailsForReport(int $reportId) 
    {
        return DB::table('reports')
            ->leftJoin('report_status', 'reports.status_id', '=', 'report_status.id')
            ->leftJoin('clients', 'reports.client_id', '=', 'clients.id')
            ->leftJoin('client_contacts', 'clients.id', '=', 'client_contacts.client_id')
            ->leftJoin('users', 'users.id', '=', 'reports.author_id')
            ->select('reports.*', 'report_status.status', 'clients.*', 'client_contacts.*', 'users.email AS author_email')
            ->where('reports.id', '=', $reportId)
            ->first();
    }

    // public function showPhaseForm($reportId) 
    // {
    //     return view('report.new_phase');
    // }

    public function generate(Request $request)
    {   
        $clientDetails = $this->getClientsDetailsForReport($request->id);
        $jobDetails = $this->getReportDetails($request->id);

        $user = User::where('id', '=', $jobDetails->author_id)
            ->get(['first_name', 'last_name'])
            ->first();
        
        $authorName = sprintf('%1$s %2$s', $user->first_name, $user->last_name);
        $docName = sprintf('%1$d_C_RPT_%2$s_%3$s', 
            date('Ymd'), 
            str_replace(' ', '_', $clientDetails->name), 
            str_replace(' ', '_', $jobDetails->assessment_name));


        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $user = User::where('id', '=', Auth::id())->first();
        $issues = $this->getReportVulns($request->id);

        // // Layout settings
        // $phpWord->setDefaultFontName('Calibri');
        // $phpWord->setDefaultFontSize(11);
        // $phpWord->getSettings()->setZoom(75);
        // $phpWord->getSettings()->setTrackRevisions(true);

        // // Set properties
        // $properties = $phpWord->getDocInfo();
        // $properties->setCreator(sprintf('%s %s', $user->first_name, $user->last_name));
        // $properties->setCreated(time());
        // $properties->setModified(time());
        
        // // Document Settings
        // $documentProtection = $phpWord->getSettings()->getDocumentProtection();
        // $documentProtection->setPassword('myPassword');

        $globalReplacements = [
            'CUST_NAME' => $clientDetails->name,
            'CUST_CONTACT_NAME' => sprintf('%1$s %2$s', $clientDetails->first_name, $clientDetails->last_name),
            'CUST_CONTACT_POSITION' => '<ADD MANUALLY>',
            'CUST_CONTACT_EMAIL' => $clientDetails->primary_email,
            'CUST_CONTACT_PHONE' => $clientDetails->phone_number,

            'AUTHOR_FULL_NAME' => $authorName,

            'APP_NAME' => $jobDetails->phase_name,
            'JOB_NAME' => $jobDetails->assessment_name,

            'DOC_NAME' => $docName,

            'CURR_DATE' => date('d/m/Y', time()),
            'CURR_FULL_DATE' => date('jS F Y', time()),

            // These need to be entered somehwere
            'TEST_START_DATE' => date('jS F Y', time()),
            'TEST_END_DATE' => date('jS F Y', time()),

            // These need to be calculated on the fly
            'ISSUE_HIGHEST_SEVERITY' => 'High',
            'ISSUE_LOWEST_SEVERITY' => 'Low',
        ];
        
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(Storage::path('uploads/Report_Template_v2.docx'));

        // App/Helpers/PHPWordHelper.php
        $phpWordHelper = new PHPWordHelper($templateProcessor);

        foreach($globalReplacements as $key => $replacement) {
            $templateProcessor->setValue($key, htmlentities($replacement));
        }

        $issueReplacements = [];
        foreach($issues as $key => $issue) {

            $refs = json_decode($issue->references, true);
            $finalRefs = implode("\n", explode(' ', $refs));

            $issueReplacements[] = [
                'ISSUE_NAME' => $issue->title,
                'ISSUE_SEVERITY' => 'THIS WILL BE CALCULATED ON THE FLY',
                'ISSUE_FINDING' => 'THIS NEEDS TO BE ADDED TO THE DB',
                'ISSUE_CVSS' => $issue->cvss_vector,
                'ISSUE_DESCRIPTION' => $issue->body,
                'ISSUE_REFERENCES' => $finalRefs,
                'ISSUE_TECHNICAL_DATA' => $issue->description,
            ];
        }
        
        $pathToFile = Storage::path('uploads/') . sprintf('%1$d_C_RPT_%2$s_%3$s_%4$s.docx', 
            date('Ymd'), 
            str_replace(' ', '_', $clientDetails->name), 
            str_replace(' ', '_', $jobDetails->assessment_name), 
            substr(hash('sha512', rand(-99999, 99999)), 4,12));

        $phpWordHelper->replaceTplVars('ISSUES_BLOCK', count($issueReplacements));
        // dd($templateProcessor->getVariables());

        foreach($issueReplacements as $key => $value) {
            foreach($value as $search => $replace) {
                $templateProcessor->setValue(htmlentities($search . '_' . ($key+1)),  htmlentities($replace));
            }
        }

        $templateProcessor->saveAs($pathToFile);

        return response()->download($pathToFile);

        // This can be an encrypted value in the database!

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vulns = Vulnerability::all();
        $issues = DB::table('report_vulnerabilities')
            ->leftJoin('vulnerabilities', 'report_vulnerabilities.vuln_id', '=', 'vulnerabilities.id')
            ->select('vulnerabilities.title', 'vulnerabilities.id')
            ->where('report_vulnerabilities.report_id', '=', $id)
            ->get();
        return view('report.configure_phase')->with([
            'report_id' => $id, 
            'vulns' => $vulns, 
            'issues' => $issues
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function addJobToClient(Request $request)
    {

        $a = Assessment::where([
            ['client_id', '=', $request->client_id],
            ['name', '=', $request->job_name],
        ])->get(['name']);

        if($a->isEmpty()) {
            $insert = new Assessment;
            $insert->name = $request->job_name;
            $insert->client_id = $request->client_id;
            $insert->save();

            $all = Assessment::where('client_id', '=', $request->client_id)->get(['name', 'id']);
            return response()->json($all);
        }
        // \Session::flash('flash_message','Office successfully added.'); //<--FLASH MESSAGE
        return response()->json(['error' => 'Job already exists']);
    }
    

    public function addPhaseToJob(Request $request)
    {
    
        // Need to fix - ReportId should be JobId 
        $a = Phase::where([
            ['name', '=', $request->phase_name],
            ['report_id', '=', $request->job_id],
        ])->get(['name']);
    
        if($a->isEmpty()) {
            $insert = new Phase;
            $insert->name = $request->phase_name;
            $insert->report_id = $request->job_id;
            $insert->author_id = Auth::id();
            $insert->comments = '';
            $insert->prefix = 'N/A';
            $insert->save();

            $all = Phase::where('report_id', '=', $request->job_id)->get(['name', 'id']);
            return response()->json($all);
        }
        return response()->json(['error' => 'Phase already exists']);

    }

    public function getJobsForClient(Request $request)
    {
        $jobs = Assessment::where('client_id', '=', $request->client_id)->get(['name', 'id']);
        return response()->json($jobs);
    }

    public function getPhasesForJob(Request $request)
    {
        $jobs = Phase::where('report_id', '=', $request->job_id)->get(['name', 'id']);
        return response()->json($jobs);
    }
   
    public function initReportCreate(Request $request)
    {
        $reportGen = new Report;
        $reportGen->client_id = $request->client_id;
        $reportGen->assessment_id = $request->job_id;
        $reportGen->author_id = Auth::id();
        $reportGen->title = '';
        $reportGen->summary = '';
        $reportGen->conclusion = '';
        $reportGen->status_id = 1;
        $reportGen->contributors = json_encode('');
        $reportGen->save();

        return redirect()->route('report.edit', [$reportGen->id]);
    }
}
