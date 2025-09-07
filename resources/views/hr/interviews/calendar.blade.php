{{-- resources/views/hr/interviews/calendar.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="tw-min-h-screen tw-bg-gray-50 tw-py-8">
    <div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8">
        {{-- En-tête --}}
        <div class="tw-mb-8">
            <div class="tw-flex tw-justify-between tw-items-center">
                <div>
                    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-900">Calendrier des Entretiens</h1>
                    <p class="tw-mt-2 tw-text-gray-600">Vue d'ensemble de tous vos entretiens planifiés</p>
                </div>
                <div class="tw-flex tw-items-center tw-space-x-4">
                    <a href="{{ route('interviews.index') }}" 
                       class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                        <i class="fas fa-list tw-mr-2"></i>
                        Vue Liste
                    </a>
                    <div class="tw-flex tw-items-center tw-space-x-2">
                        <button id="prev-month" class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-3 tw-py-2 tw-rounded-lg tw-transition tw-duration-200">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span id="current-month" class="tw-bg-orange-100 tw-text-orange-800 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-min-w-[200px] tw-text-center">
                            {{ now()->format('F Y') }}
                        </span>
                        <button id="next-month" class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-3 tw-py-2 tw-rounded-lg tw-transition tw-duration-200">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-grid tw-grid-cols-1 lg:tw-grid-cols-4 tw-gap-8">
            {{-- Calendrier principal --}}
            <div class="lg:tw-col-span-3">
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    {{-- En-tête du calendrier --}}
                    <div class="tw-bg-orange-50 tw-px-6 tw-py-4 tw-border-b tw-border-orange-200">
                        <div class="tw-grid tw-grid-cols-7 tw-gap-1">
                            <div class="tw-text-center tw-text-sm tw-font-medium tw-text-gray-700 tw-py-2">Lun</div>
                            <div class="tw-text-center tw-text-sm tw-font-medium tw-text-gray-700 tw-py-2">Mar</div>
                            <div class="tw-text-center tw-text-sm tw-font-medium tw-text-gray-700 tw-py-2">Mer</div>
                            <div class="tw-text-center tw-text-sm tw-font-medium tw-text-gray-700 tw-py-2">Jeu</div>
                            <div class="tw-text-center tw-text-sm tw-font-medium tw-text-gray-700 tw-py-2">Ven</div>
                            <div class="tw-text-center tw-text-sm tw-font-medium tw-text-gray-700 tw-py-2">Sam</div>
                            <div class="tw-text-center tw-text-sm tw-font-medium tw-text-gray-700 tw-py-2">Dim</div>
                        </div>
                    </div>

                    {{-- Corps du calendrier --}}
                    <div class="tw-p-6">
                        <div id="calendar-grid" class="tw-grid tw-grid-cols-7 tw-gap-1">
                            {{-- Les jours seront générés par JavaScript --}}
                        </div>
                    </div>
                </div>

                {{-- Légende --}}
                <div class="tw-mt-6 tw-bg-white tw-rounded-lg tw-shadow-sm tw-p-6">
                    <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900 tw-mb-4">Légende</h3>
                    <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-4">
                        <div class="tw-flex tw-items-center">
                            <div class="tw-w-4 tw-h-4 tw-bg-yellow-400 tw-rounded tw-mr-2"></div>
                            <span class="tw-text-sm tw-text-gray-700">Programmé</span>
                        </div>
                        <div class="tw-flex tw-items-center">
                            <div class="tw-w-4 tw-h-4 tw-bg-blue-400 tw-rounded tw-mr-2"></div>
                            <span class="tw-text-sm tw-text-gray-700">Visioconférence</span>
                        </div>
                        <div class="tw-flex tw-items-center">
                            <div class="tw-w-4 tw-h-4 tw-bg-green-400 tw-rounded tw-mr-2"></div>
                            <span class="tw-text-sm tw-text-gray-700">Terminé</span>
                        </div>
                        <div class="tw-flex tw-items-center">
                            <div class="tw-w-4 tw-h-4 tw-bg-red-400 tw-rounded tw-mr-2"></div>
                            <span class="tw-text-sm tw-text-gray-700">Annulé</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="tw-space-y-6">
                {{-- Entretiens du jour sélectionné --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">
                            <span id="selected-date">Aujourd'hui</span>
                        </h3>
                    </div>
                    <div id="daily-interviews" class="tw-px-6 tw-py-6">
                        <p class="tw-text-sm tw-text-gray-500 tw-text-center tw-py-4">
                            Cliquez sur une date pour voir les entretiens
                        </p>
                    </div>
                </div>

                {{-- Statistiques du mois --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Statistiques du Mois</h3>
                    </div>
                    <div class="tw-px-6 tw-py-6">
                        <div class="tw-space-y-4" id="monthly-stats">
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-sm tw-text-gray-600">Total entretiens</span>
                                <span class="tw-text-lg tw-font-bold tw-text-orange-600" id="total-interviews">0</span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-sm tw-text-gray-600">Programmés</span>
                                <span class="tw-text-lg tw-font-bold tw-text-yellow-600" id="scheduled-interviews">0</span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-sm tw-text-gray-600">Terminés</span>
                                <span class="tw-text-lg tw-font-bold tw-text-green-600" id="completed-interviews">0</span>
                            </div>
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-sm tw-text-gray-600">Annulés</span>
                                <span class="tw-text-lg tw-font-bold tw-text-red-600" id="cancelled-interviews">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Prochains entretiens --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Prochains Entretiens</h3>
                    </div>
                    <div class="tw-px-6 tw-py-6">
                        <div class="tw-space-y-4" id="upcoming-interviews">
                            {{-- Sera rempli par JavaScript --}}
                        </div>
                    </div>
                </div>

                {{-- Actions rapides --}}
                <div class="tw-bg-white tw-rounded-lg tw-shadow-sm tw-overflow-hidden">
                    <div class="tw-px-6 tw-py-4 tw-border-b tw-border-gray-200">
                        <h3 class="tw-text-lg tw-font-semibold tw-text-gray-900">Actions Rapides</h3>
                    </div>
                    <div class="tw-px-6 tw-py-6">
                        <div class="tw-space-y-3">
                            <button onclick="goToToday()" 
                                    class="tw-w-full tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                <i class="fas fa-calendar-day tw-mr-2"></i>Aujourd'hui
                            </button>
                            <a href="{{ route('interviews.index') }}" 
                               class="tw-w-full tw-bg-gray-100 hover:tw-bg-gray-200 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200 tw-text-center tw-block">
                                <i class="fas fa-list tw-mr-2"></i>Vue Liste
                            </a>
                            <button onclick="exportCalendar()" 
                                    class="tw-w-full tw-bg-blue-100 hover:tw-bg-blue-200 tw-text-blue-700 tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-transition tw-duration-200">
                                <i class="fas fa-download tw-mr-2"></i>Exporter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal pour détail d'entretien --}}
<div id="interview-modal" class="tw-fixed tw-inset-0 tw-bg-gray-600 tw-bg-opacity-50 tw-overflow-y-auto tw-h-full tw-w-full tw-hidden tw-z-50">
    <div class="tw-relative tw-top-20 tw-mx-auto tw-p-5 tw-border tw-w-96 tw-shadow-lg tw-rounded-md tw-bg-white">
        <div class="tw-mt-3">
            <div class="tw-flex tw-items-center tw-justify-between tw-mb-4">
                <h3 class="tw-text-lg tw-font-medium tw-text-gray-900" id="modal-title">Détails de l'entretien</h3>
                <button onclick="closeModal()" class="tw-text-gray-400 hover:tw-text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modal-content">
                {{-- Contenu dynamique --}}
            </div>
            <div class="tw-flex tw-justify-end tw-space-x-2 tw-mt-6">
                <button onclick="closeModal()" 
                        class="tw-bg-gray-200 hover:tw-bg-gray-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded-lg tw-transition tw-duration-200">
                    Fermer
                </button>
                <a id="modal-view-link" href="#" 
                   class="tw-bg-orange-400 hover:tw-bg-orange-500 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-transition tw-duration-200">
                    Voir détails
                </a>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript pour le calendrier --}}
<script>
// Données des entretiens depuis PHP
const interviews = @json($interviews);

// Variables globales
let currentDate = new Date();
let selectedDate = null;

// Mapping des mois en français
const monthNames = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
    updateStats();
    showUpcomingInterviews();
    
    // Event listeners
    document.getElementById('prev-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
        updateStats();
    });
    
    document.getElementById('next-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
        updateStats();
    });
});

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Mettre à jour le titre
    document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;
    
    // Calculer les jours du mois
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - (firstDay.getDay() || 7) + 1);
    
    const calendarGrid = document.getElementById('calendar-grid');
    calendarGrid.innerHTML = '';
    
    // Générer 42 jours (6 semaines)
    for (let i = 0; i < 42; i++) {
        const currentDay = new Date(startDate);
        currentDay.setDate(startDate.getDate() + i);
        
        const dayElement = createDayElement(currentDay, month);
        calendarGrid.appendChild(dayElement);
    }
}

function createDayElement(date, currentMonth) {
    const dayDiv = document.createElement('div');
    const isCurrentMonth = date.getMonth() === currentMonth;
    const isToday = date.toDateString() === new Date().toDateString();
    const dayInterviews = getInterviewsForDate(date);
    
    dayDiv.className = `tw-min-h-[100px] tw-p-2 tw-border tw-border-gray-200 tw-cursor-pointer tw-transition tw-duration-200 hover:tw-bg-gray-50 ${
        !isCurrentMonth ? 'tw-bg-gray-100 tw-text-gray-400' : ''
    } ${isToday ? 'tw-bg-orange-50 tw-border-orange-200' : ''}`;
    
    dayDiv.onclick = () => selectDate(date);
    
    // Numéro du jour
    const dayNumber = document.createElement('div');
    dayNumber.className = `tw-text-sm tw-font-medium tw-mb-1 ${isToday ? 'tw-text-orange-600' : ''}`;
    dayNumber.textContent = date.getDate();
    dayDiv.appendChild(dayNumber);
    
    // Entretiens du jour
    dayInterviews.slice(0, 3).forEach(interview => {
        const interviewDiv = document.createElement('div');
        interviewDiv.className = `tw-text-xs tw-p-1 tw-rounded tw-mb-1 tw-cursor-pointer tw-truncate ${getInterviewColor(interview)}`;
        interviewDiv.textContent = `${interview.scheduled_at.split('T')[1].substr(0,5)} ${interview.application.first_name} ${interview.application.last_name}`;
        interviewDiv.onclick = (e) => {
            e.stopPropagation();
            showInterviewModal(interview);
        };
        dayDiv.appendChild(interviewDiv);
    });
    
    // Indicateur s'il y a plus d'entretiens
    if (dayInterviews.length > 3) {
        const moreDiv = document.createElement('div');
        moreDiv.className = 'tw-text-xs tw-text-gray-500 tw-text-center';
        moreDiv.textContent = `+${dayInterviews.length - 3} autres`;
        dayDiv.appendChild(moreDiv);
    }
    
    return dayDiv;
}

function getInterviewsForDate(date) {
    const dateString = date.toISOString().split('T')[0];
    return interviews.filter(interview => 
        interview.scheduled_at.split('T')[0] === dateString
    );
}

function getInterviewColor(interview) {
    const colorMap = {
        'scheduled': 'tw-bg-yellow-200 tw-text-yellow-800',
        'completed': 'tw-bg-green-200 tw-text-green-800',
        'cancelled': 'tw-bg-red-200 tw-text-red-800',
        'rescheduled': 'tw-bg-blue-200 tw-text-blue-800'
    };
    
    // Couleur selon le type si programmé
    if (interview.status === 'scheduled') {
        const typeColors = {
            'video': 'tw-bg-blue-200 tw-text-blue-800',
            'phone': 'tw-bg-purple-200 tw-text-purple-800',
            'in_person': 'tw-bg-green-200 tw-text-green-800',
            'technical': 'tw-bg-orange-200 tw-text-orange-800'
        };
        return typeColors[interview.type] || colorMap[interview.status];
    }
    
    return colorMap[interview.status] || 'tw-bg-gray-200 tw-text-gray-800';
}

function selectDate(date) {
    selectedDate = date;
    const dayInterviews = getInterviewsForDate(date);
    
    // Mettre à jour le titre
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('selected-date').textContent = date.toLocaleDateString('fr-FR', options);
    
    // Afficher les entretiens du jour
    const container = document.getElementById('daily-interviews');
    
    if (dayInterviews.length === 0) {
        container.innerHTML = '<p class="tw-text-sm tw-text-gray-500 tw-text-center tw-py-4">Aucun entretien prévu</p>';
        return;
    }
    
    container.innerHTML = dayInterviews.map(interview => `
        <div class="tw-border-l-4 tw-border-orange-400 tw-pl-4 tw-mb-4 tw-cursor-pointer hover:tw-bg-gray-50 tw-p-2 tw-rounded" 
             onclick="showInterviewModal(interviews.find(i => i.id === ${interview.id}))">
            <div class="tw-flex tw-items-center tw-justify-between">
                <div>
                    <h4 class="tw-text-sm tw-font-medium tw-text-gray-900">
                        ${interview.application.first_name} ${interview.application.last_name}
                    </h4>
                    <p class="tw-text-xs tw-text-gray-500">
                        ${interview.scheduled_at.split('T')[1].substr(0,5)} - ${interview.application.job_offer.title}
                    </p>
                    <p class="tw-text-xs tw-text-gray-400">
                        ${interview.interviewer.name} • ${interview.duration_minutes}min
                    </p>
                </div>
                <span class="tw-inline-flex tw-items-center tw-px-2 tw-py-1 tw-rounded-full tw-text-xs tw-font-medium ${getInterviewColor(interview)}">
                    ${getStatusLabel(interview.status)}
                </span>
            </div>
        </div>
    `).join('');
}

function updateStats() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    const monthInterviews = interviews.filter(interview => {
        const interviewDate = new Date(interview.scheduled_at);
        return interviewDate.getFullYear() === year && interviewDate.getMonth() === month;
    });
    
    const stats = {
        total: monthInterviews.length,
        scheduled: monthInterviews.filter(i => i.status === 'scheduled').length,
        completed: monthInterviews.filter(i => i.status === 'completed').length,
        cancelled: monthInterviews.filter(i => i.status === 'cancelled').length
    };
    
    document.getElementById('total-interviews').textContent = stats.total;
    document.getElementById('scheduled-interviews').textContent = stats.scheduled;
    document.getElementById('completed-interviews').textContent = stats.completed;
    document.getElementById('cancelled-interviews').textContent = stats.cancelled;
}

function showUpcomingInterviews() {
    const now = new Date();
    const upcoming = interviews
        .filter(interview => new Date(interview.scheduled_at) > now && interview.status === 'scheduled')
        .sort((a, b) => new Date(a.scheduled_at) - new Date(b.scheduled_at))
        .slice(0, 5);
    
    const container = document.getElementById('upcoming-interviews');
    
    if (upcoming.length === 0) {
        container.innerHTML = '<p class="tw-text-sm tw-text-gray-500 tw-text-center">Aucun entretien à venir</p>';
        return;
    }
    
    container.innerHTML = upcoming.map(interview => `
        <div class="tw-border-l-4 tw-border-orange-400 tw-pl-4 tw-cursor-pointer hover:tw-bg-gray-50 tw-p-2 tw-rounded"
             onclick="showInterviewModal(interviews.find(i => i.id === ${interview.id}))">
            <h4 class="tw-text-sm tw-font-medium tw-text-gray-900">
                ${interview.application.first_name} ${interview.application.last_name}
            </h4>
            <p class="tw-text-xs tw-text-gray-500">
                ${new Date(interview.scheduled_at).toLocaleDateString('fr-FR')} à ${interview.scheduled_at.split('T')[1].substr(0,5)}
            </p>
            <p class="tw-text-xs tw-text-gray-400">
                ${interview.interviewer.name}
            </p>
        </div>
    `).join('');
}

function showInterviewModal(interview) {
    const modal = document.getElementById('interview-modal');
    const content = document.getElementById('modal-content');
    const viewLink = document.getElementById('modal-view-link');
    
    const typeLabels = {
        'phone': 'Téléphonique',
        'video': 'Visioconférence',
        'in_person': 'En personne',
        'technical': 'Technique'
    };
    
    content.innerHTML = `
        <div class="tw-space-y-4">
            <div>
                <h4 class="tw-font-medium tw-text-gray-900">${interview.application.first_name} ${interview.application.last_name}</h4>
                <p class="tw-text-sm tw-text-gray-600">${interview.application.job_offer.title}</p>
            </div>
            <div class="tw-grid tw-grid-cols-2 tw-gap-4 tw-text-sm">
                <div>
                    <span class="tw-font-medium tw-text-gray-700">Date:</span>
                    <p>${new Date(interview.scheduled_at).toLocaleDateString('fr-FR')}</p>
                </div>
                <div>
                    <span class="tw-font-medium tw-text-gray-700">Heure:</span>
                    <p>${interview.scheduled_at.split('T')[1].substr(0,5)}</p>
                </div>
                <div>
                    <span class="tw-font-medium tw-text-gray-700">Type:</span>
                    <p>${typeLabels[interview.type] || interview.type}</p>
                </div>
                <div>
                    <span class="tw-font-medium tw-text-gray-700">Durée:</span>
                    <p>${interview.duration_minutes} minutes</p>
                </div>
            </div>
            <div>
                <span class="tw-font-medium tw-text-gray-700">Interviewer:</span>
                <p class="tw-text-sm">${interview.interviewer.name}</p>
            </div>
            ${interview.location ? `
                <div>
                    <span class="tw-font-medium tw-text-gray-700">Lieu:</span>
                    <p class="tw-text-sm">${interview.location}</p>
                </div>
            ` : ''}
            ${interview.meeting_link ? `
                <div>
                    <span class="tw-font-medium tw-text-gray-700">Lien:</span>
                    <a href="${interview.meeting_link}" target="_blank" class="tw-text-sm tw-text-blue-600 hover:tw-text-blue-800">Rejoindre la réunion</a>
                </div>
            ` : ''}
        </div>
    `;
    
    viewLink.href = `/admin/interviews/${interview.id}`;
    modal.classList.remove('tw-hidden');
}

function closeModal() {
    document.getElementById('interview-modal').classList.add('tw-hidden');
}

function goToToday() {
    currentDate = new Date();
    renderCalendar();
    updateStats();
    selectDate(new Date());
}

function exportCalendar() {
    // Implémentation de l'export (ICS, PDF, etc.)
    alert('Fonctionnalité d\'export à implémenter');
}

function getStatusLabel(status) {
    const labels = {
        'scheduled': 'Programmé',
        'completed': 'Terminé',
        'cancelled': 'Annulé',
        'rescheduled': 'Reporté'
    };
    return labels[status] || status;
}

// Fermer la modal en cliquant en dehors
window.onclick = function(event) {
    const modal = document.getElementById('interview-modal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>
@endsection