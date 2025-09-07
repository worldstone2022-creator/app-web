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

use App\Models\Interview;
use App\Models\JobOffer;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HRDashboardController extends AccountBaseController
{
    use ImportExcel;
   // ================================
    // DASHBOARD & VUES GÉNÉRALES
    // ================================

     public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Base Légale';
    }

 public function index()
    {
        //Statistiques générales
        $this->stats = [
            'total_jobs' => JobOffer::count(),
            'active_jobs' => JobOffer::active()->count(),
            'total_applications' => JobApplication::count(),
            'pending_applications' => JobApplication::where('status', 'pending')->count(),
            'interviews_this_week' => Interview::whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'applications_this_month' => JobApplication::whereMonth('created_at', now()->month)->count()
        ];

        // Graphiques
        $this->applicationsByMonth = JobApplication::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                           ->whereYear('created_at', now()->year)
                                           ->groupBy('month')
                                           ->orderBy('month')
                                           ->get()
                                           ->pluck('count', 'month');

        $this->applicationsByStatus = JobApplication::selectRaw('status, COUNT(*) as count')
                                            ->groupBy('status')
                                            ->get()
                                            ->pluck('count', 'status');

        // // Entretiens à venir
        $this->upcomingInterviews = Interview::with(['application.jobOffer', 'interviewer'])
                                     ->upcoming()
                                     ->orderBy('scheduled_at')
                                     ->limit(5)
                                     ->get();

        // // Candidatures récentes
        $this->recentApplications = JobApplication::with(['jobOffer'])
                                          ->orderBy('created_at', 'desc')
                                          ->limit(10)
                                          ->get();

        // // Offres les plus populaires
        $this->popularJobs = JobOffer::withCount('applications')
                              ->orderBy('applications_count', 'desc')
                              ->limit(5)
                              ->get();

        return view('hr.dashboard', $this->data);
    }
}
