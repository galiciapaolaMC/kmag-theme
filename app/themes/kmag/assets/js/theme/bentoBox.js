/* eslint no-undef: 0 */

import { getCookie, checkRegionCropParams } from './manageCookies';


const initBentoBox = () => {
    const bentoBoxModule = document.querySelector('.bento-box');
    if (!bentoBoxModule) {
        return false;
    }
    getRegionCrop(bentoBoxModule);
};


// Check for crop-region params and cookies
const getRegionCrop = (bentoBoxModule) => {
    // checking the url for region and crop
    const regionCrop = checkRegionCropParams();

    if (regionCrop) {
        const [region, crop] = regionCrop;
        bentoBox(region, crop);
        fadeIn(bentoBoxModule);
    } else {
        const region = getCookie('region_cookie');
        const crop = getCookie('crop_cookie');

        if (region && crop) {
            bentoBox(region, crop);
            fadeIn(bentoBoxModule);
        }
    }

    window.addEventListener('crop_has_changed', () => {
        const bentoBoxModule = document.querySelector('.bento-box');
        const wrapper = document.querySelectorAll('.bento-box__wrapper');
        const allNodes = document.querySelectorAll('.bento-box__element');
        const moreLessButton = document.getElementById('bento-box-load-more');

        wrapper.forEach((el) => {
            el.classList.remove('showing');
        });

        setTimeout(() => {
            moreLessButton.classList.remove('expanded');
            swapButtonText('Load More');
            wrapper.forEach((el) => {
                el.classList.add('hidden');
            });
            allNodes.forEach(el => el.remove());
            
            if (!bentoBoxModule.classList.contains('unhide')) {
                bentoBox(getCookie('region_cookie'), getCookie('crop_cookie'));
                fadeIn(bentoBoxModule);
            } else {
                fadeOut(bentoBoxModule);
            }
        }, 350);
    });
};


// fade in entire component
const fadeIn = (element) => {
    element.classList.add('unhide');
    setTimeout(() => {
         element.classList.add('show');       
    }, 30);
};

// fade out entire component
const fadeOut = (element) => {
    element.classList.remove('show');
    setTimeout(() => {
         element.classList.remove('unhide');       
    }, 250);
};


// Change text on Load More/View Less button
const swapButtonText = (text) => {
    const moreLessButton = document.getElementById('bento-box-load-more');
    const buttonText = document.getElementById('bento-btn-text');

    buttonText.classList.add('fade-out');
    setTimeout(() => {
        buttonText.textContent = text;
        buttonText.classList.remove('fade-out');
    });
};


// Handles clicks on moreLessButton
const moreLessHandler = () => {
    const remaining = document.querySelectorAll('.remaining');
    const moreLessButton = document.getElementById('bento-box-load-more');
    if (moreLessButton.classList.contains('expanded')) {
        moreLessButton.classList.remove('expanded');
        swapButtonText('Load More');

        remaining.forEach((item) => {
            item.classList.add('noshow');
        });

        setTimeout(() => {
            remaining.forEach((item) => {
                item.classList.add('hide');
            });
        }, 250);
    } else {

        moreLessButton.classList.add('expanded');
        swapButtonText('View Less');

        remaining.forEach((item) => {
            item.classList.remove('hide');
        });

        setTimeout(() => {
            remaining.forEach((item) => {
                item.classList.remove('noshow');
            });
        }, 30);
    }
};


// Setting the listener on moreLessButton
const setLoadMoreLessListener = () => {
    const moreLessButton = document.getElementById('bento-box-load-more');

    moreLessButton.removeEventListener('click', moreLessHandler);
    moreLessButton.addEventListener('click', moreLessHandler);
};


// set background-color based on product path
const setBackgroundColor = (path) => {
    const component = document.querySelector('.bento-box');
    const productString = path.split('/');
    component.classList.add(`bento-box--${productString[productString.length - 2]}`);
}


// shuffle an array
const shuffle = (array) => {
    let currentIndex = array.length,  randomIndex;

    while (currentIndex != 0) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]];
    }

    return array;
};


// Determine if we are on a local install for hard coded paths
const getFolderPath = () => {
    const folder = location.hostname.split('.');
    return folder[folder.length - 1] === 'local' ? 'app' : 'wp-content';
};


// The main function for the Bento Box module
const bentoBox = (region, crop) => {
    const productData = JSON.parse(window.crop_region_product.product_json_data);
    const cropRegionProductData = JSON.parse(window.crop_region_product.crop_region_product_json);
    const agrifacts = window.crop_region_product.agrifacts;
    const bentoBox = document.querySelector('.bento-box');
    const moreLessButton = document.getElementById('bento-box-load-more');
    const host = location.protocol + '//' + location.hostname;
    let agrifactCount = 0;
    let cropImage = '', nutrientBox = '', nutrientBenefit = '', soilBenefit = '', agrifact = '', trialData = '',
         performanceAcre = '', nutrientRemovalCalculator = '', microessentialsCalculator = '',
         aspireCalculator = '';
    const urlPath = location.pathname;
    const hasPerformanceAcre = urlPath === '/performance-acre-plus/';
    const hasMicroessentials = urlPath === '/kmag/microessentials/';
    const hasAspire = urlPath === '/kmag/aspire/';
    let agrifactProduct = '';


    // Get the Agrifacts
    const getTheAgrifacts = () => {
        if (Object.keys(cropRegionProductData[crop].regions).length) {
            let products = cropRegionProductData[crop].regions[region].primaryProducts;

            if (products.length === 0) {
                products = cropRegionProductData[crop].regions[region].secondaryProducts; 
            }

            let factList = [];

            products.forEach((product) => {
                agrifacts.forEach((item) => {
                    if (item.crops[0] === crop && item.products.includes(product)) {
                        factList.push(item);

                        if (agrifactProduct === '') {
                            agrifactProduct = product;
                        }
                    }
                });
            });
            
            return factList;
        }

        return [];
    };

    // Create the title box
    const createTitleBox = () => {
        const titleBox = document.querySelector('.bento-box__title-column');
        let conditionalWord = 'the ';
        if (productData.conditionalWords.includes(region)) {
            conditionalWord = '';
        }

        const title = document.createElement('h2');
        title.innerHTML = `Growing <span>${productData[crop].title}</span> in ` +
                                `${conditionalWord}<span>${productData.regionMeta[region].title}</span>`;

        titleBox.firstChild.remove();
        titleBox.appendChild(title);
    };

    // Grab the crop image
    const getImage = () => {
        const folder = getFolderPath();
        const cropUrl = `${host}/${folder}/uploads/bento-box/bento-${crop}.jpg`;
        const cropImage = document.createElement('img');
        cropImage.src = cropUrl;
        cropImage.classList.add('bento-box__element', 'image-element');
        return cropImage;
    };


    // Create the nutrient box
    const createNutrientBox = () => {
        if (Object.keys(productData[crop].regions).length) {
            const nutrients = productData[crop].regions[region].primaryNutrients;
            const nutrientWrapper = document.createElement('div');

            nutrientWrapper.classList.add('bento-box__element', 'nutrient-wrapper');

            let nutrientHTML = `<div class="relevant-nutrients">
                                    <h2>${productData.relevantNutrients.title}</h2>
                                    <p>${productData.relevantNutrients.paragraphPartA} ` +
                                    `${productData[crop].title} ` +
                                    `${productData.relevantNutrients.paragraphPartB}</p>
                                    <div class="uk-grid-collapse column-wrapper" uk-grid>`;

            nutrients.forEach((nutrient, i) => {
                const nutrientDetail = productData.nutrientNames[nutrient];
                nutrientHTML += `<a href="/kmag/key-nutrients/${nutrient}/" class="nutrient">
                                    <p class="nutrient-symbol">${nutrientDetail.symbol}</p>
                                    <p class="nutrient-name">${nutrientDetail.name}</p>
                                </a>`;

            });

            nutrientHTML += `</div>
                            <div class="bento-btn-wrap">
                                <a href="/kmag/key-nutrients/" class="bento-btn">See the results</a>
                            </div>
                        </div>`;

            nutrientWrapper.innerHTML = nutrientHTML;

            return nutrientWrapper;
        } else {
            return;
        }
    };


    // Create benefit statement boxes
    const createBenefitsStatements = (type) => {
        const benefitWrapper = document.createElement('div');
        benefitWrapper.classList.add('bento-box__element', 'benefit-wrapper');

        let conditionalWord = 'the ';
        if (productData.conditionalWords.includes(region)) {
            conditionalWord = '';
        }
        const benefitHTML = `<h2>${productData.benefitIntro[type]} benefit for ${productData[crop].title} in ` +
                            `${conditionalWord}${productData.regionMeta[region].title}</h2>
                            <p>${productData.benefitStatements[type]}</p>`;

        benefitWrapper.innerHTML = benefitHTML;
        return benefitWrapper;
    };


    // Create performance acre box
    const createPerformanceAcre = () => {
        const performanceAcre = document.createElement('div');
        performanceAcre.classList.add('bento-box__element', 'performance-acre');

        let performanceHTML =   `<h2>
                                    <svg class="icon icon-${productData.performanceAcre.icon}">
                                        <use xlink:href="#icon-${productData.performanceAcre.icon}"></use>
                                    </svg>
                                </h2>
                                <h3 class="subtext">${productData.performanceAcre.subtext}</h3>
                                <p class="paragraph">${productData.performanceAcre.paragraph}</p>
                                <a href="/performance-acre-plus/" class="bento-btn">
                                ${productData.performanceAcre.buttonTitle}</a>`;

        performanceAcre.innerHTML = performanceHTML;

        return performanceAcre;
    }


    // Get Agrifacts
    const createAgrifactBox = (cb) => {
        const facts = getTheAgrifacts();

        if (facts.length !== 0) {
            const agrifactElement = document.createElement('div');
            agrifactElement.classList.add('bento-box__element', 'agrifact');

            let agrifactHTML =  `<h2>${facts[0].title}</h2>
                                <div class="uk-grid-collapse column-wrapper" uk-grid>
                                    <div class="uk-width-2-5@m left-side">
                                        <p class="paragraph">${facts[0].description}</p>
                                        <a href="${facts[0].url}" class="bento-btn">See the results</a>
                                    </div>
                                    <div class="uk-width-3-5@m right-side">
                                        <div class="big-number">
                                            <svg class="icon icon-arrow-up" style="width: 37px; height: 43px;">
                                                <use xlink:href="#icon-arrow-up"></use>
                                            </svg>
                                            <p>${facts[0].amount}</p>
                                        </div>
                                        <p class="units">${facts[0].unit}</p>
                                        <a href="${facts[0].url}" class="bento-btn">See the results</a>
                                    </div>
                                </div>`;

            agrifactElement.innerHTML = agrifactHTML;

            agrifact = agrifactElement;

            cb(facts.length);
        } else {
            cb(0)
        }
    };


    // Create if trial data box
    const createTrialDataBox = () => {
        const folder = getFolderPath();
        const trialUrl = `${host}/${folder}/uploads/bento-box/trial-${crop}.jpg`;
        const trialData = document.createElement('div');
        trialData.style.backgroundImage = `url(${trialUrl})`;
        trialData.classList.add('bento-box__element', 'trial-data');

        let trialDataHTML = `<h2>${productData.trialData.titlePartA} ${productData[crop].title} ` +
                            `${productData.trialData.titlePartB}</h2>
                            <a href="/kmag/trial-yield-data/?crop=${crop}&product=${agrifactProduct}" ` +
                            `class="bento-btn">${productData.trialData.buttonTitle}</a>`;

        trialData.innerHTML = trialDataHTML;

        return trialData;
    };


    // Create calculator boxes
    const createCalculatorBox = (type) => {
        const calculatorWrapper = document.createElement('div');
        calculatorWrapper.classList.add('bento-box__element', 'calculator-wrapper', `${type}`);

        let calculatorHTML =  `<h2>${productData.calculators[type].title}</h2>
                        <div class="uk-grid-collapse uk-child-width-1-2@m column-wrapper" uk-grid>
                            <div class="left-side  ${type}-calculator">
                                <p class="paragraph">${productData.calculators[type].paragraph}</p>
                                <a href="${productData.calculators[type].urlPath}" class="bento-btn">
                                ${productData.calculators[type].buttonTitle}</a>
                            </div>
                            <div class="right-side ${type}-calculator">`;

        if (type === 'nutrient') {
            calculatorHTML += `<p class="big-number">${productData.calculators[type].number}</p>
                                <p class="units">${productData.calculators[type].units}</p>
                                <svg class="icon icon-bar-graph">
                                        <use xlink:href="#icon-bar-graph"></use>
                                </svg>`;
        } else {
            calculatorHTML +=   `<div class="icon-wrapper">
                                    <div class="inner-wrapper">
                                        <svg class="icon icon-${type}">
                                            <use xlink:href="#icon-${type}"></use>
                                        </svg>
                                        <p>${productData.calculators[type].graphicText}</p>
                                    </div>
                                </div>`;
        }
                                
        calculatorHTML += `<a href="${productData.calculators[type].urlPath}" class="bento-btn">
                                ${productData.calculators[type].buttonTitle}</a>
                            </div>
                        </div>`;

        calculatorWrapper.innerHTML = calculatorHTML;
        return calculatorWrapper;
    };


    // Sort boxes into columns and fix height discrepency
    const addBoxesToPage = (initial, remaining) => {
        const wrapper = document.querySelectorAll('.bento-box__wrapper');
        const leftCell = document.querySelector('.bento-box__left-cell');
        const rightCell = document.querySelector('.bento-box__right-cell');
        const mobileCell = document.querySelector('.bento-box__mobile-cell');
        const loadEvent = new Event('bento_box_loaded');
        let cell = false;

        // Alternate columns to which items are added
        initial.forEach((item) => {
            if (cell) {
                rightCell.appendChild(item);
                cell = false;
            } else {
                leftCell.appendChild(item);
                cell = true;
            }
        });

        if (remaining) {
            remaining.forEach((item) => {
                let clonedItem = item.cloneNode(true);
                item.classList.add('remaining', 'desktop', 'hide', 'noshow');
                clonedItem.classList.add('remaining', 'mobile', 'hide', 'noshow');
                if (cell) {
                    rightCell.appendChild(item);
                    cell = false;
                } else {
                    leftCell.appendChild(item);
                    cell = true;
                }
                mobileCell.appendChild(clonedItem);
            });

            moreLessButton.classList.remove('hidden');
            setLoadMoreLessListener()
        } else {
            moreLessButton.classList.add('hidden');
        }

        setTimeout(() => {
            const leftHeight = leftCell.clientHeight;
            const rightHeight = rightCell.clientHeight;
            const screenWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;

            // On desktop we check for a large variance in column height.
            // If we find a large variance, we move the shortest element
            // from the tall column to the short column.
            if (screenWidth >= 960 && Math.abs(leftHeight - rightHeight) > 300) {

                if (leftHeight > rightHeight) {
                    const boxes = Array.from(document.querySelectorAll('.bento-box__left-cell > div:not(.hide)'));

                    const shortest = boxes.reduce((short, item) => {
                        return short.clientHeight < item.clientHeight ? short : item;
                    });

                    rightCell.prepend(shortest);
                } else {
                    const boxes = Array.from(document.querySelectorAll('.bento-box__right-cell > div:not(.hide)'));

                    const shortest = boxes.reduce((short, item) => {
                        return short.clientHeight < item.clientHeight ? short : item;
                    });

                    leftCell.prepend(shortest);
                }
            }

            // Show the Component
            wrapper.forEach((el) => {
                el.classList.remove('hidden');
                el.classList.add('showing');
            });

            // let other components know that this is loaded
            window.dispatchEvent(loadEvent);
        },30);
    }; // end addBoxesToPage()


    // Randomize the boxes and sort into initial and load more arrays
    const randomizeDisplay = () => {
        // All potential box options to be added to page
        const boxArray = [cropImage, nutrientBox, nutrientBenefit,
                            soilBenefit, agrifact, trialData, performanceAcre,
                            nutrientRemovalCalculator, microessentialsCalculator,
                            aspireCalculator
                        ];

        // Get all non-empty box options
        let builtBoxes = boxArray.filter((box) => {
            return box;
        });


        if (builtBoxes.length > 6) {
            let initial = builtBoxes.splice(0,6);
            let remaining = builtBoxes;

            // Since we have more than 6, we swap a benefit
            // statement for an item in the load-more array
            if (hasPerformanceAcre) {
                if (!initial.includes(performanceAcre)) {
                    let index = remaining.indexOf(performanceAcre);
                    remaining.splice(index, 1);
                    initial.push(performanceAcre);
                } else {
                    remaining = shuffle(remaining);
                    let popped = remaining.pop();
                    initial.push(popped);
                }
            } else if (hasMicroessentials && remaining.includes(microessentialsCalculator)) {
                let index = remaining.indexOf(microessentialsCalculator);
                remaining.splice(index, 1);
                initial.push(microessentialsCalculator);
            } else if (hasAspire && remaining.includes(aspireCalculator)) {
                let index = remaining.indexOf(aspireCalculator);
                remaining.splice(index, 1);
                initial.push(aspireCalculator);
            } else {
                remaining = shuffle(remaining);
                let popped = remaining.pop();
                initial.push(popped);
            }
            let benefits = shuffle([nutrientBenefit, soilBenefit]);
            let index = initial.indexOf(benefits[0]);
            initial.splice(index, 1);
            remaining.push(benefits[0]);

            // shuffle the final arrays
            initial = shuffle(initial);
            remaining = shuffle(remaining);
            
            addBoxesToPage(initial, remaining);
        } else {
            // if we have 6 or less items, we simply
            // shuffle the items and add to the page
            builtBoxes = shuffle(builtBoxes);
            
            addBoxesToPage(builtBoxes);
        }
    }; // end randomizeDisplay()


    // Create the various boxes for the component
    const setUpBentoBoxes = () => {

        // Create Title box
        createTitleBox();

        // Create the image 
        cropImage = getImage();
        
        // Create nutrient box
        nutrientBox = createNutrientBox();

        // Create Benefit Statements
        nutrientBenefit = createBenefitsStatements('nutrient');
        soilBenefit = createBenefitsStatements('soil');

        // Create Performance Acre statement
        if (hasPerformanceAcre) {
            performanceAcre = createPerformanceAcre();
        }

        // get and set agrifact(s)
        createAgrifactBox((agrifactCount) => {
            if (agrifactCount > 1) {
                trialData = createTrialDataBox();
            }
        });

        // check and setup nutrient removal calculator cta
        if (productData.calculators.nutrient.crops.includes(crop)) {
            nutrientRemovalCalculator = createCalculatorBox('nutrient');
        }

        // check and setup microessentials calculator cta
        if (productData.calculators.microessentials.crops.includes(crop)) {
            if (hasPerformanceAcre || hasMicroessentials) {
                microessentialsCalculator = createCalculatorBox('microessentials');
            }
        }
        // check and setup aspire calculator cta
        if (productData.calculators.aspire.crops.includes(crop)) {
            if (hasPerformanceAcre || hasAspire) {
                aspireCalculator = createCalculatorBox('aspire');
            }
        }
    }; // end setUpBentoBoxes()
    

    // it all starts here
    setBackgroundColor(urlPath);
    setUpBentoBoxes();
    randomizeDisplay();

} // end main bentoBox()

export default initBentoBox;


