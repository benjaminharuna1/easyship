# Taste

## Routing & URLs
- Prefers public-facing pages to live at clean, shareable GET URLs with a path parameter (e.g., `/track/{trackingId}`) instead of POST-to-a-results-page flows (e.g., `POST /track/results`), so pages are bookmarkable and linkable. Confidence: 0.8
- Keeps legacy URLs working via graceful redirects when renaming/restructuring routes. Confidence: 0.6

## Design & front-end
- When an HTML file is given as a design reference ("take note of the design"), the resulting page should mirror that document's layout and content structure. Confidence: 0.7
- When rebuilding an existing page, prefers a clean, modern, self-contained design over preserving the legacy Bootstrap 3/AdminLTE look — keep the reference's information structure but restyle it modern and print-friendly (system fonts, CSS variables, `@media print` rules). Confidence: 0.85
- Prefers configuration-driven values (e.g., API keys from settings) over hard-coded keys/secrets in client-side code. Confidence: 0.75
