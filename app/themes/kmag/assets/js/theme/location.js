function successCallback(pos) {
  alert("Latitude: " + pos.coords.latitude + " , Longitude: " + pos.coords.longitude);
}

const options = {
  enableHighAccuracy: true,
  timeout: 10000,
  maximumAge: 300000 
};

function errorCallback (err) {
  switch(err.code) {
    case 1:
      alert("Sorry, but this application does not have the permission to use geolocation");
      break;
    case 2:
      alert("Sorry, but a problem happened while getting your location");
      break;
    case 3:
      alert("Sorry, this is taking too long...");
      break;
    default:
      alert("unknown");
  }
}


const initLocation = () => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);
  } else {
    console.log('Sorry, your browser does not support geolocation');
  }
}

export default initLocation
