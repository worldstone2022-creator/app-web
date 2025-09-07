<?php

namespace App\Http\Controllers;


use App\Helper\Files;
use App\Helper\Reply;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use App\Jobs\ImportProductJob;
use App\DataTables\ProductsDataTable;
use App\Http\Controllers\AccountBaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Admin\Employee\ImportRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Admin\Employee\ImportProcessRequest;
use App\Traits\ImportExcel;

use App\Models\JobOffer;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobOfferController extends AccountBaseController
{
    use ImportExcel;
   // ================================
    // DASHBOARD & VUES GÉNÉRALES
    // ================================

     public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Gestion des Offres d\'Emploi';
        // $this->middleware(
        //     function ($request, $next) {
        //         in_array('admin', user_roles()));

        //         return $next($request);
        //     }
        // );
    }

     public function index(Request $request)
    { 
         $company = session('company');
        $query = JobOffer::with(['creator', 'applications']);
        
        $query->where('companyId', $company->id);
        // Filtres
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $this->jobOffers = $query->orderBy('created_at', 'desc')->paginate(10);

        $this->departments = JobOffer::distinct()->pluck('department');
        $this->types = ['CDI', 'CDD', 'Stage', 'Freelance', 'Alternance'];

        return view('hr.job-offers.index', $this->data);
    }

    public function create()
    {
        $this->departments = JobOffer::all();

        return view('hr.job-offers.create',$this->data);
    }

    public function store(Request $request)
    {
       
        $company = session('company');
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'required|string|max:255',
            'type' => 'required|in:CDI,CDD,Stage,Freelance,Alternance',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'requirements' => 'nullable',
            'benefits' => 'nullable',
            'deadline' => 'required|date|after:today',
            'positions_available' => 'required|integer|min:1'
        ]);

       

        $validated['created_by'] = Auth::id();
        $validated['companyId'] = $company->id;
        $validated['status'] = 'draft';
        JobOffer::create($validated);
        return redirect()->route('job-offers.index'); 
    }

    public function show(JobOffer $jobOffer)
    {
        $this->jobOffer = $jobOffer->load(['applications.workflows', 'applications.interviews']);
        $company = session('company');
        $this->applicationStats = [
            'total' => $jobOffer->applications->where('companyId', $company->id)->count(),
            'pending' => $jobOffer->applications->where('companyId', $company->id)->where('status', 'pending')->count(),
            'reviewing' => $jobOffer->applications->where('companyId', $company->id)->where('status', 'reviewing')->count(),
            'shortlisted' => $jobOffer->applications->where('companyId', $company->id)->where('status', 'shortlisted')->count(),
            'interviewed' => $jobOffer->applications->where('companyId', $company->id)->where('status', 'interviewed')->count(),
            'accepted' => $jobOffer->applications->where('companyId', $company->id)->where('status', 'accepted')->count(),
            'rejected' => $jobOffer->applications->where('companyId', $company->id)->where('status', 'rejected')->count(),
        ];

        return view('hr.job-offers.show',$this->data);
    }

    public function edit(JobOffer $jobOffer)
    {
        $this->jobOffer = $jobOffer;
        return view('hr.job-offers.edit', $this->data);
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'required|string|max:255',
            'type' => 'required|in:CDI,CDD,Stage,Freelance,Alternance',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'requirements' => 'nullable',
            'benefits' => 'nullable',
            'deadline' => 'required|date',
            'positions_available' => 'required|integer|min:1',
            'status' => 'required|in:draft,active,paused,closed'
        ]);

        $jobOffer->update($validated);

        return redirect()->route('job-offers.show', $jobOffer)
                        ->with('success', 'Offre d\'emploi mise à jour avec succès!');
    }

    public function destroy(JobOffer $jobOffer)
    {
        $jobOffer->delete();

        return redirect()->route('job-offers.index')
                        ->with('success', 'Offre d\'emploi supprimée avec succès!'); 
    }

    public function publish(JobOffer $jobOffer)
    {
        $jobOffer->update(['status' => 'active']);

        return redirect()->back()
                        ->with('success', 'Offre d\'emploi publiée avec succès!');
    }

    public function close(JobOffer $jobOffer)
    {
        $jobOffer->update(['status' => 'closed']);

        return redirect()->back()
                        ->with('success', 'Offre d\'emploi fermée avec succès!');
    }

   
}
