<form action="{{ route('search') }}" method="GET" class="search-form">
    <div class="input-group input-group-lg">
        <input type="text" 
               name="q" 
               class="form-control" 
               placeholder="Rechercher des articles, fiches, exercices..." 
               value="{{ request('q') }}"
               required
               minlength="2">
        <button class="btn btn-danger text-white" type="submit">
            <i class="fas fa-search"></i>
            <span class="d-none d-md-inline ms-2">Rechercher</span>
        </button>
    </div>
</form>