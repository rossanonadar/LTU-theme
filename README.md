# LTU Theme

Custom WordPress theme scaffold for the LTU project. It ships with a Webpack-driven asset pipeline, SCSS architecture, native CPT/meta integration, an admin-friendly Projects workflow, and a REST-powered enhancement for the Projects listing page.

## Requirements

- WordPress 6.6+
- PHP 8.1+
- Node.js 18+ / npm

## Theme Structure

```
LTU-theme/
├── functions.php            # Boots theme + includes
├── inc/
│   ├── setup.php            # Theme supports + menus
│   ├── assets.php           # Webpack bundle enqueue
│   ├── post-types/
│   │   └── project.php      # CPT + register_post_meta helpers
│   ├── admin/
│   │   ├── project-meta-box.php   # Editor fields UI
│   │   └── project-list-table.php # Admin columns/sorting/filter
│   ├── api/
│   │   └── projects.php     # GET /wp-json/ltu/v1/projects
│   └── …
├── template-projects.php    # Projects listing page template
├── single-project.php       # Single Project layout
├── template-parts/
│   ├── forms/…
│   └── projects/…
├── src/
│   ├── js/app.js            # Global entry (imports SCSS + pages)
│   ├── js/pages/projects.js # Client-side filters + metrics
│   └── scss/…
└── assets/                  # Build output (css/js)
```

## Getting Started

1. **Install dependencies**
   ```bash
   npm install
   ```
2. **Build once** (production)
   ```bash
   npm run build
   ```
3. **Watch during development**
   ```bash
   npm run dev
   ```
   Webpack writes `assets/js/app.js` and `assets/css/app.css`, and `inc/assets.php` enqueues them when present.

## Projects Data Model

- Custom post type: `project`
- Core fields: Title + Content
- Meta fields (registered via `register_post_meta`):
  - `client_name` (string)
  - `status` (enum: planned / in-progress / completed)
  - `budget` (float)
  - `start_date` (YYYY-MM-DD)

Data is editable through the “Project Details” meta box and exposed in the REST API + Gutenberg sidebar thanks to `show_in_rest => true`.

### Admin UX

- Projects list table shows Client / Status / Budget / Start Date columns
- Columns are sortable (status, budget, start date)
- Dropdown filter above the table filters by status

### Front-End Templates

- `template-projects.php` – assign to a Page to show all Projects with filters. Includes a total budget summary and a JS enhancement that fetches data via `/wp-json/ltu/v1/projects` so filters update without reload. Without JS, the form submits traditionally.
- `single-project.php` – displays the individual project with status pill, meta grid, and full description.

## REST API

Endpoint: `GET /wp-json/ltu/v1/projects`

Query params:
- `status` – optional slug (`planned`, `in-progress`, `completed`)
- `client` – optional partial match for client name

Response example:
```json
[
  {
    "id": 42,
    "title": "Project Alpha",
    "permalink": "https://site.test/projects/project-alpha/",
    "client_name": "Acme Corp",
    "status": {"slug":"completed","label":"Completed"},
    "budget": 125000,
    "start_date": "2025-11-20",
    "excerpt": "Short summary",
    "content": "<p>Full content…</p>",
    "featured_image": "https://site.test/uploads/alpha.jpg"
  }
]
```

The Projects listing page consumes this endpoint for its client-side filtering.

## Styling

- SCSS organized into `_variables.scss`, `_mixins.scss`, `_layout.scss`, and component partials under `src/scss/components/`
- `px-to-rem()` utility + breakpoint mixins in `_mixins.scss`
- Use `npm run dev` for live recompiles

## JS Architecture

- `src/js/app.js` imports global SCSS and any page-level modules
- Page-specific behavior lives in `src/js/pages/<page>.js` (currently only `projects.js`)

## Development Tips

- Flush permalinks after enabling the theme (Settings → Permalinks → Save)
- To extend meta filters, update both `inc/admin/project-list-table.php` and `inc/api/projects.php`
- When adding new SCSS/JS modules, import them through the existing entry files to keep bundles coherent

## License

GPL-2.0-or-later
