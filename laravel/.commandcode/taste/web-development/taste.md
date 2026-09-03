# Taste

## Routing & URLs
- Prefers public-facing pages to live at clean, shareable GET URLs with a path parameter (e.g., `/track/{trackingId}`) instead of POST-to-a-results-page flows (e.g., `POST /track/results`), so pages are bookmarkable and linkable. Confidence: 0.8
- Keeps legacy URLs working via graceful redirects when renaming/restructuring routes. Confidence: 0.6

## Design & front-end
- When an HTML file is given as a design reference ("take note of the design"), the resulting page should mirror that document's layout and content structure. Confidence: 0.7
- When rebuilding an existing page, prefers a clean, modern, self-contained design over preserving the legacy Bootstrap 3/AdminLTE look — keep the reference's information structure but restyle it modern and print-friendly (system fonts, CSS variables, `@media print` rules). Confidence: 0.85
- Prefers configuration-driven values (e.g., API keys from settings) over hard-coded keys/secrets in client-side code. Confidence: 0.75
- On long timelines/lists (e.g., shipment history), prefers progressive disclosure: show only the most recent items (e.g., latest 5) by default and collapse older ones behind an expandable "view older" toggle, to keep focus on current updates. Confidence: 0.7
- Treats mobile/tablet responsiveness as a first-class requirement: the header/navigation must collapse into a working hamburger menu at mobile breakpoints, not just function on desktop (asked to "check the mobile responsiveness ... ensure the hamburger is working as expected on mobile view"). Confidence: 0.55
- Uses a purchased/custom HTML theme (module CSS + main.js wiring) inside a Laravel app, where templates override theme behavior with inline `<style>` blocks — debugging front-end issues requires tracing the interplay of theme CSS/JS selectors, responsive.css breakpoints, and any inline overrides rather than assuming the theme CSS applies as-is. Confidence: 0.5
