const initScript = () => {
  const resourceBackButtonElement = document.getElementById('back-to-resources-button-container');

  if (resourceBackButtonElement !== null && document.referrer.includes('resource-library')) {
    resourceBackButtonElement.style.display = 'block';
    resourceBackButtonElement.addEventListener('click', handleResourceButtonClick);
  }
}

const handleResourceButtonClick = (e) => {
  history.back();
}

export default initScript;