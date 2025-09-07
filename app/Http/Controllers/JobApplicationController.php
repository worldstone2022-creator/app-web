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
use Illuminate\Support\Facades\Mail;
class JobApplicationController extends AccountBaseController
{
    use ImportExcel;
   // ================================
    // DASHBOARD & VUES GÉNÉRALES
    // ================================

     public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Base Légale';
        // $this->middleware(
        //     function ($request, $next) {
        //         in_array('client', user_roles()) ? abort_403(!(in_array('orders', $this->user->modules) && user()->permission('add_order') == 'all')) : abort_403(!in_array('products', $this->user->modules));

        //         return $next($request);
        //     }
        // );
    }

    public function index(Request $request)
    {
        $query = JobApplication::with(['jobOffer', 'workflows.assignedUser']);
        $company = session('company');
        $query->where('companyId', $company->id);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('job_offer_id')) {
            $query->where('job_offer_id', $request->job_offer_id);
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $this->applications = $query->orderBy('created_at', 'desc')->paginate(15);

        $this->jobOffers = JobOffer::active()->get();
        $this->statuses = ['pending', 'reviewing', 'shortlisted', 'interview_scheduled', 'interviewed', 'test_assigned', 'test_completed', 'accepted', 'rejected'];

        return view('hr.applications.index', $this->data);
    }

    public function show(JobApplication $application)
    {
       $this->application = $application->load(['jobOffer', 'workflows.assignedUser', 'interviews.interviewer']);
        
        return view('hr.applications.show', $this->data);
    }

public function updateStatus(Request $request, JobApplication $application)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,reviewing,shortlisted,interview_scheduled,interviewed,test_assigned,test_completed,accepted,rejected',
        'notes' => 'nullable|string|max:1000'
    ]);

    $application->update([
        'status' => $validated['status'],
        'updated_at' => now()
    ]);

    // Créer une nouvelle étape de workflow
    $application->workflows()->create([
        'stage' => ucfirst(str_replace('_', ' ', $validated['status'])),
        'description' => 'Statut mis à jour : ' . $validated['status'],
        'status' => 'completed',
        'completed_at' => now(),
        'assigned_to' => Auth::id(),
        'notes' => $validated['notes'] ?? null
    ]);

    // Notification par email au candidat (optionnelle)
    // Envoi d'un email simple au candidat
    // Tableau des statuts traduits
    $statuses = [
        'pending' => 'En attente',
        'reviewing' => 'En cours d\'examen',
        'shortlisted' => 'Présélectionné',
        'interview_scheduled' => 'Entretien programmé',
        'interviewed' => 'Entretien réalisé',
        'test_assigned' => 'Test assigné',
        'test_completed' => 'Test complété',
        'accepted' => 'Accepté',
        'rejected' => 'Rejeté',
    ];

    $statusLabel = $statuses[$validated['status']] ?? ucfirst($validated['status']);
    $company = session('company');

    if($validated['status'] === 'accepted') {
        // Envoyer un email de félicitations au candidat
        Mail::raw('Félicitations ! Votre candidature dans l\'entreprise ' . $company->company_name . ' a été acceptée.', function ($message) use ($application) {
            $message->to($application->email)
                    ->subject('Félicitations pour votre candidature');
        });
    } elseif($validated['status'] === 'rejected') {
        // Envoyer un email de rejet au candidat
        Mail::raw('Nous regrettons de vous informer que votre candidature dans l\'entreprise ' . $company->company_name . ' n\'a pas été retenue.', function ($message) use ($application) {
            $message->to($application->email)
                    ->subject('Etat de votre candidature');
        });
    }else {
       Mail::raw('Votre statut de candidature dans l\'entreprise ' . $company->company_name . ' a été mis à jour : ' . $statusLabel, function ($message) use ($application) {
        $message->to($application->email)
                ->subject('Etat de votre candidature');
    });
    }

    
    return redirect()->back()
                    ->with('success', 'Statut de la candidature mis à jour avec succès !');
}

/**
 * Mise à jour de l'évaluation d'une candidature
 */
public function updateRating(Request $request, JobApplication $application)
{
    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'notes' => 'nullable|string|max:1000'
    ]);

    $application->update([
        'rating' => $validated['rating'],
        'notes' => $validated['notes'],
        'updated_at' => now()
    ]);

    // Créer une étape de workflow pour l'évaluation
    $application->workflows()->create([
        'stage' => 'Évaluation',
        'description' => 'Candidature évaluée : ' . $validated['rating'] . '/5 étoiles',
        'status' => 'completed',
        'completed_at' => now(),
        'assigned_to' => Auth::id(),
        'notes' => $validated['notes'] ?? null
    ]);

    return redirect()->back()
                    ->with('success', 'Évaluation mise à jour avec succès !');
}

}
