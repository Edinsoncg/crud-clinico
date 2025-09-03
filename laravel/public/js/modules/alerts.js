document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.alert.auto-dismiss').forEach(alertElement => {
    const timeoutMilliseconds = parseInt(alertElement.dataset.timeout || '4000', 10);

    setTimeout(() => {
        if (window.bootstrap && bootstrap.Alert) {
            bootstrap.Alert.getOrCreateInstance(alertElement).close();
        } else {
            alertElement.classList.remove('show');
            setTimeout(() => alertElement.remove(), 150);
        }
    }, timeoutMilliseconds);
  });
});
