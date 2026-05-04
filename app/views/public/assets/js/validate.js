/**
 * GreenBite — Shared inline field validation helpers
 * Include this in any page that needs inline field errors.
 */

const ERR_ICON = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;

/**
 * Show a red error message under a field.
 * @param {HTMLElement} field  - the input / textarea / select
 * @param {string}      msg    - error message text
 */
function showFieldError(field, msg) {
  field.classList.add('is-invalid');
  field.classList.remove('is-valid');
  let el = field.parentElement.querySelector('.field-error');
  if (!el) {
    el = document.createElement('div');
    el.className = 'field-error';
    field.parentElement.appendChild(el);
  }
  el.innerHTML = ERR_ICON + ' ' + msg;
  el.classList.add('show');
}

/**
 * Clear the error state on a field.
 * @param {HTMLElement} field
 * @param {boolean}     markValid  - whether to add green border
 */
function clearFieldError(field, markValid = false) {
  field.classList.remove('is-invalid');
  if (markValid) field.classList.add('is-valid');
  const el = field.parentElement.querySelector('.field-error');
  if (el) el.classList.remove('show');
}

/**
 * Clear ALL errors inside a form.
 * @param {HTMLFormElement} form
 */
function clearAllErrors(form) {
  form.querySelectorAll('.is-invalid').forEach(f => f.classList.remove('is-invalid','is-valid'));
  form.querySelectorAll('.field-error').forEach(e => e.classList.remove('show'));
}

/**
 * Attach real-time blur+input validation to a field.
 * @param {HTMLElement} field
 * @param {Function}    validateFn  - returns error string or null
 */
function attachLiveValidation(field, validateFn) {
  const run = () => {
    const err = validateFn(field.value);
    if (err) showFieldError(field, err);
    else clearFieldError(field, field.value.trim() !== '');
  };
  field.addEventListener('blur', run);
  field.addEventListener('input', () => {
    if (field.classList.contains('is-invalid')) run();
  });
}
