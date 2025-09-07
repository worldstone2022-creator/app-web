<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AccountBaseController;
use Illuminate\Support\Facades\Auth;
use App\Traits\ImportExcel;

use App\Models\MedicalVisit;
use App\Models\User;



class MedicalVisitController extends AccountBaseController
{
    use ImportExcel;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Santé et sécurité';
        // $this->middleware(
        //     function ($request, $next) {
        //         in_array('client', user_roles()) ? abort_403(!(in_array('orders', $this->user->modules) && user()->permission('add_order') == 'all')) : abort_403(!in_array('products', $this->user->modules));

        //         return $next($request);
        //     }
        // );
    }


    public function index()
    {
        $user = Auth::user();
        $userInfo = User::find($user->id);
        $companyId = $userInfo->company_id;
        $this->medicalVisits = MedicalVisit::with('user')
            ->where('company_id', $companyId)
            ->orderBy('scheduled_date', 'asc')
            ->paginate(10);

        $this->stats = [
            'total' => MedicalVisit::where('company_id', $companyId)->count(),
            'upcoming' => MedicalVisit::where('company_id', $companyId)
                ->where('scheduled_date', '>=', now())
                ->where('result', 'Non effectué')->count(),
            'overdue' => MedicalVisit::where('company_id', $companyId)
                ->where('scheduled_date', '<', now())
                ->where('result', 'Non effectué')->count(),
        ];

        return view('hospital.index', $this->data);
    }

    public function create()
    {
        $user = Auth::user();
        $userInfo = User::find($user->id);
        $this->users = User::where('company_id', $userInfo->company_id)->get();
        return view('hospital.create', $this->data);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'visit_type' => 'required|in:Embauche,Périodique,Reprise de services',
        //     'visit_object' => 'required|string',
        //     'doctor_name' => 'required|string',
        //     'scheduled_date' => 'required|date|after:today',
        // ]);
        // $user = Auth::user();
        // $userInfo = User::find($user->id);
        // MedicalVisit::create([
        //     'company_id' => $userInfo->company_id,
        //     'user_id' => $request->user_id,
        //     'visit_type' => $request->visit_type,
        //     'visit_object' => $request->visit_object,
        //     'doctor_name' => $request->doctor_name,
        //     'scheduled_date' => $request->scheduled_date,
        //     'notes' => $request->notes,
        // ]);

        return redirect()->route('hospital.index');
    }

    public function show(MedicalVisit $medicalVisit)
    {

        $this->medicalVisit = $medicalVisit;
        return view('hospital.show', $this->data);
    }

    public function edit(MedicalVisit $medicalVisit)
    {
        $user = Auth::user();
        $userInfo = User::find($user->id);
        $this->medicalVisit = $medicalVisit;
        $this->users = User::where('company_id', $userInfo->company_id)->get();
        return view('hospital.edit', $this->data);
    }

    public function update(Request $request, MedicalVisit $medicalVisit)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'visit_type' => 'required|in:Embauche,Périodique,Reprise de services',
            'visit_object' => 'required|string',
            'doctor_name' => 'required|string',
            'scheduled_date' => 'required|date',
            'visit_date' => 'nullable|date',
            'result' => 'required|in:Apte,Inapte,Non effectué',
        ]);

        if ($request->hasFile('certificate')) {
            if ($medicalVisit->certificate_path) {
                Storage::delete($medicalVisit->certificate_path);
            }
            $path = $request->file('certificate')->store('certificates', 'private');
            $medicalVisit->certificate_path = $path;
        }

        $medicalVisit->update($request->except('certificate'));

        return redirect()->route('hospital.index');
    }

    public function downloadCertificate(MedicalVisit $medicalVisit)
    {
        if (!$medicalVisit->certificate_path) {
            abort(404);
        }
        return Storage::download($medicalVisit->certificate_path);
    }
}
