<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">🔗 Liens Utiles SEO</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <a href="{{ config('app.url') }}/sitemap.xml" target="_blank" class="btn btn-outline-success w-100">
                    <i class="bi bi-file-earmark-code"></i> Sitemap Public
                </a>
            </div>
            <div class="col-md-3">
                <a href="https://search.google.com/search-console" target="_blank" class="btn btn-outline-primary w-100">
                    <i class="bi bi-google"></i> Search Console
                </a>
            </div>
            <div class="col-md-3">
                <a href="https://analytics.google.com" target="_blank" class="btn btn-outline-info w-100">
                    <i class="bi bi-graph-up"></i> Google Analytics
                </a>
            </div>
            <div class="col-md-3">
                <a href="https://www.bing.com/webmasters" target="_blank" class="btn btn-outline-warning w-100">
                    <i class="bi bi-bing"></i> Bing Webmaster
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">
                    💡 Après génération, soumettez le sitemap dans Google Search Console pour améliorer l'indexation.
                </small>
            </div>
            <div class="col-md-6">
                <small class="text-muted">
                    <strong>📍 URL du sitemap :</strong> <code>{{ config('app.url') }}/sitemap.xml</code>
                </small>
            </div>
        </div>
    </div>
</div>