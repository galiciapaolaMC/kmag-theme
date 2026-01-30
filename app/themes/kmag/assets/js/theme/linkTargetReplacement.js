const shouldReplaceLinkTargets = window?.replace_link_target_attribute?.replace;

const initLinkTargetReplacement = () => {
  if (shouldReplaceLinkTargets) {
    const links = document.querySelectorAll('a');
    links.forEach(link => {
      link.setAttribute('target', '_top');
    });
  }
}

export default initLinkTargetReplacement;