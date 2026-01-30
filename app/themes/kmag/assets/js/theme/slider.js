import UIkit from './UIKit';

const initSlider = () => {
  const slider = UIkit.slider('.uk-nutrient-slider', {
      'draggable': true,
      'finite': true
    });
};

export default initSlider;
