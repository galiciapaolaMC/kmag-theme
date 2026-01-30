import Player from '@vimeo/player';

const handleVimeoPlay = e => {
  console.log('vimeo play', e);
  const vimeoPlay = new Event('vimeo-play');

  window.dispatchEvent(vimeoPlay);
}

const initVimeo = () => {
  const iframes = document.querySelectorAll('iframe');

  iframes.forEach(iframe => {
    if (iframe.src.includes('vimeo')) {
      const player = new Player(iframe);

      player.on('play', handleVimeoPlay);
    }
  })
}

export default initVimeo;