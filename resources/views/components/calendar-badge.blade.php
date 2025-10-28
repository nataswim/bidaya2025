@auth
    @if(auth()->user()->hasRole('user') || auth()->user()->hasRole('editor') || auth()->user()->hasRole('admin'))
        <span id="calendar-badge" class="badge bg-danger rounded-pill ms-2" style="display: none;">0</span>
    @endif
@endauth

@push('scripts')
<script>
// Charger le compteur d'événements de la semaine
function loadCalendarBadge() {
    fetch('/user/calendar/api/week-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('calendar-badge');
            if (badge && data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-block';
            }
        })
        .catch(error => console.log('Badge calendar error:', error));
}

// Charger au chargement de la page
document.addEventListener('DOMContentLoaded', loadCalendarBadge);

// Recharger toutes les 5 minutes
setInterval(loadCalendarBadge, 300000);
</script>
@endpush