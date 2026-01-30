const UserTrackingId = () => {
  var PARAM_NAME = 'uid';
  var STORAGE_KEY = 'userTrackingId';
  var UID_REGEX = /^[A-Za-z0-9_-]+$/;

  function isValidUid(uid) {
    return UID_REGEX.test(uid);
  }

  function initUserTrackingId() {
    try {
      var url = new URL(window.location.href);
      var uid = url.searchParams.get(PARAM_NAME);

      if (uid && isValidUid(uid)) {
        // Persist in localStorage
        try {
          localStorage.setItem(STORAGE_KEY, uid);
        } catch (e) {
          // localStorage might be disabled; just ignore
        }

        url.searchParams.delete(PARAM_NAME);
        window.history.replaceState({}, '', url.toString());
      }
    } catch (e) {
      console.error('User tracking init error:', e);
    }
  }

  window.getUserTrackingId = function () {
    try {
      return localStorage.getItem(STORAGE_KEY);
    } catch (e) {
      return null;
    }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUserTrackingId);
  } else {
    initUserTrackingId();
  }
};

export default UserTrackingId;