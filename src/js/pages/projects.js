const apiBase = window?.ltuTheme?.restBase || '/wp-json/ltu/v1/projects';

// Formats a number as currency (USD)
const formatCurrency = (value) => {
  if (!value && value !== 0) {
    return '';
  }

  return new Intl.NumberFormat(undefined, {
    style: 'currency',
    currency: 'USD'
  }).format(value);
};

// `renders` table rows based on the provided projects data
const renderRows = (tableBody, projects) => {
  if (!tableBody) {
    return;
  }

  // Generate table rows
  tableBody.innerHTML = projects.map((project) => {
    const date = project.start_date ? new Date(project.start_date) : null;
    const localizedDate = date
      ? date.toLocaleDateString(undefined, {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        })
      : '';

    return `
      <tr>
        <td data-label="Project">
          <a class="project-link" href="${project.permalink}">${project.title}</a>
        </td>
        <td data-label="Client">${project.client_name ?? ''}</td>
        <td data-label="Status" data-project-status="${project.status.slug}">${project.status.label}</td>
        <td data-label="Budget">${project.budget ? formatCurrency(project.budget) : ''}</td>
        <td data-label="Start Date">${localizedDate}</td>
      </tr>
    `;
  }).join('');
};

// Updates the summary section with total budget
const updateSummary = (summaryEl, projects) => {
  if (!summaryEl) {
    return;
  }

  const total = projects.reduce((sum, project) => sum + (project.budget || 0), 0);
  const totalEl = summaryEl.querySelector('[data-projects-total]');

  // Update total budget display
  if (totalEl) {
    totalEl.textContent = formatCurrency(total);
  }
};

// Sets up event listeners and logic for filtering projects
const setupProjectsFilters = () => {
  const filtersForm = document.querySelector('.projects-filters');
  const tableWrapper = document.querySelector('[data-projects-table]');

  // Ensure necessary elements are present
  if (!filtersForm || !tableWrapper) {
    return;
  }

  // Elements
  const tbody = tableWrapper.querySelector('tbody');
  const summary = tableWrapper.querySelector('[data-projects-summary]');
  const statusField = filtersForm.querySelector('[name="project_status"]');
  const clientField = filtersForm.querySelector('[name="client_query"]');
  const resetLink = filtersForm.querySelector('[data-projects-reset]');

  // Toggles the visibility of the reset link
  const toggleReset = () => {
    if (!resetLink) {
      return;
    }

    // Show reset link if any filter is active
    if ((statusField?.value || '').trim() || (clientField?.value || '').trim()) {
      resetLink.classList.add('is-visible');
    } else {
      resetLink.classList.remove('is-visible');
    }
  };

  // Handles form submission to fetch and render filtered projects
  filtersForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    // Build query parameters
    const params = new URLSearchParams();

    // Add filters to query parameters
    if (statusField?.value) {
      params.append('status', statusField.value);
    }

    // Add client query to parameters
    if (clientField?.value) {
      params.append('client', clientField.value);
    }

    // Construct endpoint URL
    const endpoint = params.toString() ? `${apiBase}?${params.toString()}` : apiBase;
    try {
      filtersForm.classList.add('is-loading');
      const response = await fetch(endpoint);

      if (!response.ok) {
        throw new Error('Failed to fetch projects.');
      }

      // Parse and render projects
      const projects = await response.json();
      renderRows(tbody, projects);
      updateSummary(summary, projects);
      toggleReset();
    } catch (error) {
      console.error(error);
    } finally {
      filtersForm.classList.remove('is-loading');
    }
  });

  // Handles reset link click to clear filters
  resetLink?.addEventListener('click', (event) => {
    // Do nothing if no filters are active
    if (!statusField && !clientField) {
      return;
    }

    event.preventDefault();
    if (statusField) {
      statusField.value = '';
    }
    if (clientField) {
      clientField.value = '';
    }
    toggleReset();
    filtersForm.requestSubmit();
  });

  toggleReset();
};

// Initialize the projects filters when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', setupProjectsFilters);
