window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    const mainContent = document.getElementById('main-content');

    loader.style.display = 'flex';
    mainContent.style.display = 'none';

    setTimeout(() => {
        loader.style.display = 'none';
        mainContent.style.display = 'block';
    }, 3000);
});