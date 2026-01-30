
const initCloseModalForm = () => {
    const closeButton = document.getElementById('close-modal-form');

    if (closeButton) {
        closeButton.addEventListener('click', () => {
            console.log('clicked close modal form');
            const modal = document.querySelector('.modal-form');
            if (modal) {
                modal.classList.add('hide-modal');
            }
        });
    }
};

export default initCloseModalForm;