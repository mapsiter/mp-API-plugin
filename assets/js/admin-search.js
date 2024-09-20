// Replace search submit button text on MP BE Test admin
document.addEventListener('DOMContentLoaded', () => {
  if (window.location.href.includes('mp_be_test')) {
    const button = document.getElementById('search-submit');
    if (button) {
      button.value = 'Search MP BE Tests';
    }
  }
});