  const modal = document.getElementById('itemModal');
  const openBtn = document.getElementById('addItemBtn');
  const closeBtn = document.getElementById('closeModal');
  const cancelBtn = document.getElementById('cancelBtn');

  openBtn.addEventListener('click', () => modal.style.display = 'flex');
  closeBtn.addEventListener('click', () => modal.style.display = 'none');
  cancelBtn.addEventListener('click', () => modal.style.display = 'none');

  window.addEventListener('click', (e) => {
    if (e.target == modal) modal.style.display = 'none';
  });