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

use App\Models\User;
use App\Models\Interview;
use App\Models\JobOffer;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InterviewController extends AccountBaseController
{
    use ImportExcel;
   // ================================
    // DASHBOARD & VUES GÉNÉRALES
    // ================================

     public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Planification des Entretiens';
        // $this->middleware(
        //     function ($request, $next) {
        //         in_array('client', user_roles()) ? abort_403(!(in_array('orders', $this->user->modules) && user()->permission('add_order') == 'all')) : abort_403(!in_array('products', $this->user->modules));

        //         return $next($request);
        //     }
        // );
    }

   public function index(Request $request)
    {
        $query = Interview::with(['application.jobOffer', 'interviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('scheduled_at', $request->date);
        }

        $this->interviews = $query->orderBy('scheduled_at', 'asc')->paginate(15);

        $this->upcomingInterviews = Interview::upcoming()
                                     ->with(['application.jobOffer', 'interviewer'])
                                     ->limit(5)
                                     ->get();

        return view('hr.interviews.index', $this->data);
    }

    public function create(JobApplication $application)
    {
        $this->application = $application;
        //vardump($application);
        //dd($application);
        $this->users = User::where('status', 'active')->get();
        
        return view('hr.interviews.create', $this->data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_application_id' => 'required|exists:job_applications,id',
            'type' => 'required|in:phone,video,in_person,technical',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'location' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url',
            'agenda' => 'nullable|string',
            'interviewer_id' => 'required|exists:users,id',
            'additional_interviewers' => 'nullable|array',
            'evaluation_criteria' => 'nullable|array'
        ]);

        $interview = Interview::create($validated);

        // Mettre à jour le statut de la candidature
        $interview->application->update(['status' => 'interview_scheduled']);

        // Créer une étape de workflow
        $interview->application->workflows()->create([
            'stage' => 'Entretien programmé',
            'description' => 'Entretien ' . $validated['type'] . ' programmé',
            'status' => 'pending',
            'scheduled_at' => $validated['scheduled_at'],
            'assigned_to' => $validated['interviewer_id']
        ]);

        return redirect()->route('interviews.show', $interview)
                        ->with('success', 'Entretien programmé avec succès!');
    }

    public function show(Interview $interview)
    {
       $this->interview = $interview->load(['application.jobOffer', 'interviewer']);
       $this->users = User::where('status', 'active')->get();
        return view('hr.interviews.show', $this->data);
    }

    public function edit(Interview $interview)
    {
        $this->interview = $interview->load(['application.jobOffer', 'interviewer']);
        $this->users = User::where('status', 'active')->get();
        
        return view('hr.interviews.edit', $this->data);
    }

    public function update(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'type' => 'required|in:phone,video,in_person,technical',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'location' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url',
            'agenda' => 'nullable|string',
            'interviewer_id' => 'required|exists:users,id',
            'additional_interviewers' => 'nullable|array',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled'
        ]);

        $interview->update($validated);

        return redirect()->route('interviews.show', $interview)
                        ->with('success', 'Entretien mis à jour avec succès!');
    }

    public function addFeedback(Request $request, Interview $interview)
    {
        $validated = $request->validate([
            'feedback' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'evaluation_criteria' => 'nullable|array'
        ]);

        $validated['status'] = 'completed';
        $interview->update($validated);

        // Mettre à jour la candidature
        $interview->application->update([
            'status' => 'interviewed',
            'rating' => $validated['rating']
        ]);

        // Créer une étape de workflow
        $interview->application->workflows()->create([
            'stage' => 'Entretien terminé',
            'description' => 'Entretien terminé avec retour',
            'status' => 'completed',
            'completed_at' => now(),
            'assigned_to' => Auth::id(),
            'notes' => $validated['feedback']
        ]);

        return redirect()->back()
                        ->with('success', 'Retour d\'entretien ajouté avec succès!');
    }

    public function calendar()
    {
        $interviews = Interview::with(['application.jobOffer', 'interviewer'])
                              ->whereDate('scheduled_at', '>=', now()->startOfMonth())
                              ->whereDate('scheduled_at', '<=', now()->endOfMonth())
                              ->get();

        return view('hr.interviews.calendar', compact('interviews'));
    }

    
    public function cancel(Interview $interview)
    {
        $interview->update(['status' => 'cancelled']);

        // Mettre à jour la candidature
        $interview->application->update(['status' => 'new']);

        // Créer une étape de workflow
        $interview->application->workflows()->create([
            'stage' => 'Entretien annulé',
            'description' => 'Entretien annulé',
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'assigned_to' => Auth::id()
        ]);

        return redirect()->back()
                        ->with('success', 'Entretien annulé avec succès!');
    }

public function reschedule(Request $request, Interview $interview)
{
    $validated = $request->validate([
        'scheduled_at' => 'required|date|after:now',
        'interviewer_id' => 'required|exists:users,id',
    ]);

    $interview->update([
        'scheduled_at' => $validated['scheduled_at'],
        'status' => 'rescheduled',
        'interviewer_id' => $validated['interviewer_id'],
    ]);

    // Mettre à jour la candidature
    $interview->application->update(['status' => 'interview_rescheduled']);

    // Créer une étape de workflow
    $interview->application->workflows()->create([
        'stage' => 'Entretien reporté',
        'description' => 'Entretien reporté à ' . $validated['scheduled_at'],
        'status' => 'rescheduled',
        'rescheduled_at' => now(),
        'assigned_to' => $validated['interviewer_id'],
    ]);

    return redirect()->route('interviews.show', $interview)
                    ->with('success', 'Entretien reporté avec succès!');
}



}
