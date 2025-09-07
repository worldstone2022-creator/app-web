<?php

namespace App\Console\Commands;

use App\Models\MedicalVisit;
use App\Notifications\MedicalVisitReminder;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendMedicalVisitReminders extends Command
{
    protected $signature = 'medical:send-reminders';
    protected $description = 'Envoie des rappels pour les visites médicales à venir';

    public function handle()
    {
        // Rappels 7 jours avant
        $upcomingVisits = MedicalVisit::with(['user', 'company'])
            ->where('scheduled_date', Carbon::today()->addDays(7))
            ->where('result', 'Non effectué')
            ->get();

        foreach ($upcomingVisits as $visit) {
            $visit->user->notify(new MedicalVisitReminder($visit));
        }

        // Rappels visites en retard
        $overdueVisits = MedicalVisit::with(['user', 'company'])
            ->where('scheduled_date', '<', Carbon::today())
            ->where('result', 'Non effectué')
            ->get();

        foreach ($overdueVisits as $visit) {
            // Notifier les RH de l'entreprise
            $hrUsers = $visit->company->users()->where('role', 'hr')->get();
            foreach ($hrUsers as $hr) {
                $hr->notify(new MedicalVisitReminder($visit, true));
            }
        }

        $this->info('Rappels envoyés: ' . ($upcomingVisits->count() + $overdueVisits->count()));
    }
}