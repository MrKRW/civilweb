/* ============================================================
   CONTACT PAGE — contact.js
============================================================ */

(function () {
  'use strict';

  /* ----------------------------------------
     1. Back to Top
  ---------------------------------------- */
  const backTop = document.getElementById('back-top');

  window.addEventListener('scroll', function () {
    if (!backTop) return;
    backTop.classList.toggle('visible', window.scrollY > 300);
  }, { passive: true });

  if (backTop) {
    backTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ----------------------------------------
     2. Contact Form — validation & submit
  ---------------------------------------- */
  const form     = document.getElementById('contact-form');
  const formNote = document.getElementById('ct-form-note');

  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      const name     = document.getElementById('contact-name').value.trim();
      const email    = document.getElementById('contact-email').value.trim();
      const phone    = document.getElementById('contact-phone').value.trim();
      const location = document.getElementById('contact-location').value.trim();
      const service  = document.getElementById('contact-service').value.trim();
      const message  = document.getElementById('contact-message').value.trim();

      if (!name || !email || !phone || !location || !service || !message) {
        showNote('Please fill in all fields.', 'error');
        return;
      }
      if (!isValidEmail(email)) {
        showNote('Please enter a valid email address.', 'error');
        return;
      }

      const submitBtn = document.getElementById('ct-submit');
      submitBtn.disabled = true;
      submitBtn.querySelector('span').textContent = 'Sending…';

      try {
        const formData = new FormData(form);
        const res = await fetch((typeof API_BASE !== 'undefined' ? API_BASE : '') + '/api/contact-form', {
          method: 'POST',
          body: formData
        });

        const data = await res.json();
        
        if (data.success) {
          showNote('Thank you! Your message has been sent.', 'success');
          form.reset();
        } else {
          showNote(data.error || 'Something went wrong. Please try again.', 'error');
        }
      } catch (err) {
        showNote('Network error. Please try again later.', 'error');
      } finally {
        submitBtn.disabled = false;
        submitBtn.querySelector('span').textContent = 'Send Message';
      }
    });
  }

  function showNote(msg, type) {
    if (!formNote) return;
    formNote.textContent = msg;
    formNote.className = 'ct-form-note ' + type;
    setTimeout(() => {
      formNote.textContent = '';
      formNote.className = 'ct-form-note';
    }, 5000);
  }

  function isValidEmail(e) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e);
  }

})();
