const initScript = () => {
    const superBackButtonElement = document.getElementById('super-back-button-container');
    const sessionStorageItem = sessionStorage.getItem('super-back-referral-url');
    if (superBackButtonElement !== null && sessionStorageItem !== null) {
        superBackButtonElement.style.display = 'block';
        superBackButtonElement.addEventListener('click', handleSuperBackClick);
    }
}

const handleSuperBackClick = (e) => {
    history.back();
    sessionStorage.removeItem('super-back-referral-url');
}

export default initScript;