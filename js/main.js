(function () {
  document.addEventListener("click", (event) => {
    if (event.target.matches("dialog")) {
      event.target.close();
    }

    if (!event.target.matches("[data-dialog]")) return;
    event.preventDefault();

    const dialogId = event.target.dataset.dialog;
    const dialog = document.querySelector(`#${dialogId}`);

    dialog.showModal();
  });
})();
