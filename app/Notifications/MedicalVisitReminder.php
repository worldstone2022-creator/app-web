<?php

namespace App\Notifications;

use App\Models\MedicalVisit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MedicalVisitReminder extends Notification
{
    use Queueable;

    protected $medicalVisit;
    protected $isOverdue;

    public function __construct(MedicalVisit $medicalVisit, $isOverdue = false)
    {
        $this->medicalVisit = $medicalVisit;
        $this->isOverdue = $isOverdue;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->isOverdue ? 'Visite médicale en retard' : 'Rappel: Visite médicale programmée';

        return (new MailMessage)
            ->subject($subject)
            ->line($this->isOverdue ? 'Une visite médicale est en retard.' : 'Vous avez une visite médicale programmée.')
            ->line('Utilisateur: ' . $this->medicalVisit->user->first_name . ' ' . $this->medicalVisit->user->last_name)
            ->line('Type: ' . $this->medicalVisit->visit_type)
            ->line('Date: ' . $this->medicalVisit->scheduled_date->format('d/m/Y'))
            ->line('Médecin: ' . $this->medicalVisit->doctor_name);
    }

    public function toArray($notifiable)
    {
        return [
            'medical_visit_id' => $this->medicalVisit->id,
            'user_name' => $this->medicalVisit->user->first_name . ' ' . $this->medicalVisit->user->last_name,
            'visit_type' => $this->medicalVisit->visit_type,
            'scheduled_date' => $this->medicalVisit->scheduled_date->format('d/m/Y'),
            'is_overdue' => $this->isOverdue,
        ];
    }
}