/**
 * Gestion du formulaire de création/édition d'événement
 * Avec checkboxes pour workouts et exercices
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========== ÉLÉMENTS DOM ==========
    const workoutSectionSelect = document.getElementById('workout_section');
    const workoutCategorySelect = document.getElementById('workout_category');
    const workoutsContainer = document.getElementById('workouts-container');
    
    const exerciceCategorySelect = document.getElementById('exercice_category');
    const exercicesContainer = document.getElementById('exercices-container');
    
    // ========== CHARGEMENT INITIAL ==========
    
    if (workoutSectionSelect) {
        loadWorkoutSections();
    }
    
    if (exerciceCategorySelect) {
        loadExerciceCategories();
        loadExercices(); // Charger tous les exercices par défaut
    }
    
    // ========== WORKOUT : GESTION EN CASCADE ==========
    
    /**
     * Charger les sections de workout
     */
    function loadWorkoutSections() {
        fetch('/user/calendar/api/workout-sections')
            .then(response => response.json())
            .then(data => {
                workoutSectionSelect.innerHTML = '<option value="">Choisir une section</option>';
                data.forEach(section => {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.name;
                    workoutSectionSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erreur chargement sections:', error);
                workoutSectionSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    }
    
    /**
     * Event : Changement de section
     */
    if (workoutSectionSelect) {
        workoutSectionSelect.addEventListener('change', function() {
            const sectionId = this.value;
            
            // Reset catégorie et workouts
            workoutCategorySelect.innerHTML = '<option value="">Choisir une catégorie</option>';
            workoutCategorySelect.disabled = true;
            workoutsContainer.innerHTML = '<p class="text-muted">Sélectionnez une section et une catégorie</p>';
            
            if (!sectionId) return;
            
            // Charger les catégories
            workoutCategorySelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/user/calendar/api/workout-categories/${sectionId}`)
                .then(response => response.json())
                .then(data => {
                    workoutCategorySelect.innerHTML = '<option value="">Choisir une catégorie</option>';
                    
                    if (data.length === 0) {
                        workoutCategorySelect.innerHTML = '<option value="">Aucune catégorie disponible</option>';
                        return;
                    }
                    
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        workoutCategorySelect.appendChild(option);
                    });
                    
                    workoutCategorySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Erreur chargement catégories:', error);
                    workoutCategorySelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        });
    }
    
    /**
     * Event : Changement de catégorie
     */
    if (workoutCategorySelect) {
        workoutCategorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            
            workoutsContainer.innerHTML = '<p class="text-muted">Sélectionnez une catégorie</p>';
            
            if (!categoryId) return;
            
            // Charger les workouts
            workoutsContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p>Chargement des séances...</p></div>';
            
            fetch(`/user/calendar/api/workouts/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        workoutsContainer.innerHTML = '<div class="alert alert-info">Aucune séance disponible dans cette catégorie</div>';
                        return;
                    }
                    
                    displayWorkouts(data);
                })
                .catch(error => {
                    console.error('Erreur chargement workouts:', error);
                    workoutsContainer.innerHTML = '<div class="alert alert-danger">Erreur lors du chargement</div>';
                });
        });
    }
    
    /**
     * Afficher les workouts avec checkboxes (UNE SEULE sélection possible)
     */
    function displayWorkouts(workouts) {
        workoutsContainer.innerHTML = '';
        
        // Note explicative
        const note = document.createElement('div');
        note.className = 'alert alert-info mb-3';
        note.innerHTML = '<i class="fas fa-info-circle me-2"></i>Vous ne pouvez sélectionner qu\'<strong>une seule séance</strong> par activité.';
        workoutsContainer.appendChild(note);
        
        const row = document.createElement('div');
        row.className = 'row g-3';
        
        workouts.forEach(workout => {
            const col = document.createElement('div');
            col.className = 'col-md-6';
            
            const card = document.createElement('div');
            card.className = 'card h-100 workout-card';
            card.style.cursor = 'pointer';
            card.innerHTML = `
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input workout-checkbox" 
                               type="radio" 
                               name="workout_id" 
                               value="${workout.id}" 
                               id="workout_${workout.id}">
                        <label class="form-check-label w-100" for="workout_${workout.id}" style="cursor: pointer;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-dumbbell text-primary fa-lg me-3 mt-1"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">${workout.title}</h6>
                                    ${workout.short_description ? `<small class="text-muted">${workout.short_description.substring(0, 80)}...</small>` : ''}
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            `;
            
            // Clic sur la carte sélectionne le radio
            card.addEventListener('click', function(e) {
                if (e.target.type !== 'radio') {
                    const radio = card.querySelector('input[type="radio"]');
                    radio.checked = true;
                    updateWorkoutCards();
                }
            });
            
            col.appendChild(card);
            row.appendChild(col);
        });
        
        workoutsContainer.appendChild(row);
        
        // Event sur les radios
        document.querySelectorAll('.workout-checkbox').forEach(radio => {
            radio.addEventListener('change', updateWorkoutCards);
        });
        
        // Restaurer la sélection si en mode édition
        restoreWorkoutSelection();
    }
    
    /**
     * Mettre à jour l'apparence des cartes workout
     */
    function updateWorkoutCards() {
        document.querySelectorAll('.workout-card').forEach(card => {
            const radio = card.querySelector('input[type="radio"]');
            if (radio && radio.checked) {
                card.classList.add('border-primary', 'bg-primary-subtle');
            } else {
                card.classList.remove('border-primary', 'bg-primary-subtle');
            }
        });
    }
    
    /**
     * Restaurer la sélection en mode édition
     */
    function restoreWorkoutSelection() {
        const selectedWorkoutId = document.querySelector('input[name="workout_id"]:checked');
        if (selectedWorkoutId) {
            updateWorkoutCards();
        }
    }
    
    // ========== EXERCICES : GESTION AVEC CHECKBOXES ==========
    
    /**
     * Charger les catégories d'exercices
     */
    function loadExerciceCategories() {
        fetch('/user/calendar/api/exercice-categories')
            .then(response => response.json())
            .then(data => {
                exerciceCategorySelect.innerHTML = '<option value="">Tous les exercices</option>';
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    exerciceCategorySelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erreur chargement catégories exercices:', error);
                exerciceCategorySelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    }
    
    /**
     * Charger les exercices
     */
    function loadExercices(categoryId = null) {
        const url = categoryId 
            ? `/user/calendar/api/exercices/${categoryId}`
            : '/user/calendar/api/exercices';
        
        exercicesContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-success" role="status"></div><p>Chargement des exercices...</p></div>';
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    exercicesContainer.innerHTML = '<div class="alert alert-info">Aucun exercice disponible</div>';
                    return;
                }
                
                displayExercices(data);
            })
            .catch(error => {
                console.error('Erreur chargement exercices:', error);
                exercicesContainer.innerHTML = '<div class="alert alert-danger">Erreur lors du chargement</div>';
            });
    }
    
    /**
     * Event : Changement de catégorie d'exercices
     */
    if (exerciceCategorySelect) {
        exerciceCategorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            loadExercices(categoryId);
        });
    }
    
    /**
     * Afficher les exercices avec checkboxes (MULTIPLE sélection)
     */
    function displayExercices(exercices) {
        exercicesContainer.innerHTML = '';
        
        // Note explicative
        const note = document.createElement('div');
        note.className = 'alert alert-success mb-3';
        note.innerHTML = '<i class="fas fa-info-circle me-2"></i>Vous pouvez sélectionner <strong>plusieurs exercices</strong>.';
        exercicesContainer.appendChild(note);
        
        // Compteur de sélection
        const counter = document.createElement('div');
        counter.className = 'alert alert-primary mb-3';
        counter.id = 'exercice-counter';
        counter.innerHTML = '<i class="fas fa-check-circle me-2"></i><strong>0</strong> exercice(s) sélectionné(s)';
        exercicesContainer.appendChild(counter);
        
        const row = document.createElement('div');
        row.className = 'row g-2';
        
        exercices.forEach(exercice => {
            const col = document.createElement('div');
            col.className = 'col-md-6';
            
            const card = document.createElement('div');
            card.className = 'card h-100 exercice-card';
            card.style.cursor = 'pointer';
            card.innerHTML = `
                <div class="card-body p-3">
                    <div class="form-check">
                        <input class="form-check-input exercice-checkbox" 
                               type="checkbox" 
                               name="exercice_ids[]" 
                               value="${exercice.id}" 
                               id="exercice_${exercice.id}">
                        <label class="form-check-label w-100" for="exercice_${exercice.id}" style="cursor: pointer;">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-running text-success me-2 mt-1"></i>
                                <div class="flex-grow-1">
                                    <strong class="d-block">${exercice.titre}</strong>
                                    <small class="text-muted">
                                        <span class="badge bg-info-subtle text-info">${exercice.niveau}</span>
                                        ${exercice.type ? `<span class="badge bg-secondary-subtle text-secondary ms-1">${exercice.type}</span>` : ''}
                                    </small>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            `;
            
            // Clic sur la carte toggle la checkbox
            card.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    const checkbox = card.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                    updateExerciceCards();
                }
            });
            
            col.appendChild(card);
            row.appendChild(col);
        });
        
        exercicesContainer.appendChild(row);
        
        // Event sur les checkboxes
        document.querySelectorAll('.exercice-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateExerciceCards);
        });
        
        // Restaurer la sélection si en mode édition
        restoreExerciceSelection();
        updateExerciceCards();
    }
    
    /**
     * Mettre à jour l'apparence des cartes exercices
     */
    function updateExerciceCards() {
        const counter = document.getElementById('exercice-counter');
        let count = 0;
        
        document.querySelectorAll('.exercice-card').forEach(card => {
            const checkbox = card.querySelector('input[type="checkbox"]');
            if (checkbox && checkbox.checked) {
                card.classList.add('border-success', 'bg-success-subtle');
                count++;
            } else {
                card.classList.remove('border-success', 'bg-success-subtle');
            }
        });
        
        if (counter) {
            counter.innerHTML = `<i class="fas fa-check-circle me-2"></i><strong>${count}</strong> exercice(s) sélectionné(s)`;
        }
    }
    
    /**
     * Restaurer la sélection en mode édition
     */
    function restoreExerciceSelection() {
        const selectedExerciceIds = Array.from(document.querySelectorAll('input[name="exercice_ids[]"]:checked'))
            .map(cb => cb.value);
        
        if (selectedExerciceIds.length > 0) {
            updateExerciceCards();
        }
    }
    
    // ========== GESTION DES ONGLETS ==========
    
    const workoutTab = document.getElementById('workout-tab');
    const exerciceTab = document.getElementById('exercice-tab');
    
    if (workoutTab) {
        workoutTab.addEventListener('click', function() {
            // Décocher tous les exercices
            document.querySelectorAll('.exercice-checkbox').forEach(cb => cb.checked = false);
            updateExerciceCards();
        });
    }
    
    if (exerciceTab) {
        exerciceTab.addEventListener('click', function() {
            // Décocher le workout
            document.querySelectorAll('.workout-checkbox').forEach(radio => radio.checked = false);
            updateWorkoutCards();
        });
    }
    
    // ========== VALIDATION AVANT SOUMISSION ==========
    
    const eventForm = document.getElementById('eventForm');
    
    if (eventForm) {
        eventForm.addEventListener('submit', function(e) {
            const selectedWorkout = document.querySelector('input[name="workout_id"]:checked');
            const selectedExercices = document.querySelectorAll('input[name="exercice_ids[]"]:checked');
            
            // Vérifier qu'on n'a pas les deux en même temps
            if (selectedWorkout && selectedExercices.length > 0) {
                e.preventDefault();
                alert('❌ Vous ne pouvez pas lier à la fois une séance ET des exercices.\nVeuillez choisir l\'un ou l\'autre.');
                return false;
            }
            
            return true;
        });
    }
    
});
/**
 * Fonction globale pour pré-sélectionner un workout (utilisée par edit.blade.php)
 */
window.preselectWorkout = function(workoutId) {
    // Attendre un peu que les workouts soient chargés
    const maxAttempts = 10;
    let attempts = 0;
    
    const checkAndSelect = setInterval(() => {
        attempts++;
        const radio = document.querySelector(`input[name="workout_id"][value="${workoutId}"]`);
        
        if (radio) {
            radio.checked = true;
            radio.dispatchEvent(new Event('change'));
            clearInterval(checkAndSelect);
        } else if (attempts >= maxAttempts) {
            clearInterval(checkAndSelect);
            console.warn('Workout not found after', maxAttempts, 'attempts');
        }
    }, 500);
};

/**
 * Fonction globale pour pré-sélectionner des exercices (utilisée par edit.blade.php)
 */
window.preselectExercices = function(exerciceIds) {
    const ids = Array.isArray(exerciceIds) ? exerciceIds : exerciceIds.split(',');
    
    const maxAttempts = 10;
    let attempts = 0;
    
    const checkAndSelect = setInterval(() => {
        attempts++;
        let foundCount = 0;
        
        ids.forEach(id => {
            const checkbox = document.querySelector(`input[name="exercice_ids[]"][value="${id}"]`);
            if (checkbox) {
                checkbox.checked = true;
                foundCount++;
            }
        });
        
        if (foundCount === ids.length) {
            // Tous trouvés, mettre à jour l'apparence
            updateExerciceCards();
            clearInterval(checkAndSelect);
        } else if (attempts >= maxAttempts) {
            // Arrêter après X tentatives
            if (foundCount > 0) {
                updateExerciceCards();
            }
            clearInterval(checkAndSelect);
            console.warn('Some exercices not found. Found:', foundCount, '/', ids.length);
        }
    }, 500);
};