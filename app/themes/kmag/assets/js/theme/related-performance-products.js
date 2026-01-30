const initScript = () => {
    document.addEventListener('DOMContentLoaded', function() {
        const containerElement = document.querySelector('.related-performance-products');
        const previousButtonElement = document.querySelector('.related-content-list__previous-button');
        const nextButtonElement = document.querySelector('.related-content-list__next-button')
        let indexOffset = 0;
        let performanceProducts = [];

        // check if related products exist before proceeding
        if (containerElement !== null) {
            performanceProducts = getPerformanceProducts();
            let visibleProductCount = Math.min(performanceProducts.length, 3);
            let visibleIndicies = getVisibleIndicies(indexOffset, visibleProductCount);

            // initialize arrow controls and their disable state
            disableArrowControls(indexOffset, visibleProductCount, performanceProducts.length);

            // set up controls event listeners
            previousButtonElement.addEventListener('click', function() {
                if (indexOffset > 0) {
                    indexOffset = indexOffset - 1;
                    visibleIndicies = visibleIndicies.map(index => {
                        return index - 1;
                    });
                    setProductVisibility(visibleIndicies);
                    disableArrowControls(indexOffset, visibleProductCount, performanceProducts.length);
                }
            });

            nextButtonElement.addEventListener('click', function() {
                if (indexOffset < performanceProducts.length - visibleIndicies.length) {
                    indexOffset = indexOffset + 1;
                    visibleIndicies = visibleIndicies.map(index => {
                        return index + 1;
                    });
                    setProductVisibility(visibleIndicies);
                    disableArrowControls(indexOffset, visibleProductCount, performanceProducts.length);
                }
                
            })

            // set up resize listener 
            window.addEventListener('resize', function(e) {
                let visibleIndexCount = 0;
                const initialCount = visibleProductCount;
                const { target } = e;
                const { innerWidth } = target;

                handleWindowResize(innerWidth);
            })

            // resize handler reinitializes script at different breakpoints
            const handleWindowResize = (innerWidth) => {
                const initialCount = visibleProductCount;
                if (innerWidth >= 1200) {
                    visibleProductCount = 3;
                } else if (innerWidth >= 780) {
                    visibleProductCount = 2;
                } else {
                    visibleProductCount = 1;
                }
                if (initialCount !== visibleProductCount) {
                    indexOffset = 0;
                    visibleIndicies = getVisibleIndicies(indexOffset, visibleProductCount)
                    setProductVisibility(visibleIndicies);
                    disableArrowControls(indexOffset, visibleProductCount, performanceProducts.length);
                    setControlVisibility(performanceProducts.length, visibleProductCount);
                }
            }

            // get window size on load
            handleWindowResize(window.innerWidth);
        }
    })

    const disableArrowControls = (indexOffset, visibleProductCount, totalProductCount) => {
        const previousButtonElement = document.querySelector('.related-content-list__previous-button');
        const nextButtonElement = document.querySelector('.related-content-list__next-button')
        
        if (indexOffset === 0) {
            previousButtonElement.disabled = true;
        } else {
            previousButtonElement.disabled = false;
        }
        if ((indexOffset + visibleProductCount) === totalProductCount) {
            nextButtonElement.disabled = true;
        } else {
            nextButtonElement.disabled = false;
        }
    }
    
    const getVisibleIndicies = (indexOffset, visibleIndexCount) => {
        let result = [];
        for (var i = 0; i < visibleIndexCount; i++) {
            result.push(indexOffset + i);
        }
        return result;
    }
    
    const getPerformanceProducts = () => {
        return document.querySelectorAll('.related-performance-product');
    }
    
    const setProductVisibility = visibleList => {
        const products = getPerformanceProducts();
        [...products].forEach(product => {
            const index = product.getAttribute('data-pp-index');
            const isCurrentlyVisible = product.getAttribute('data-pp-visible');
            if (visibleList.includes(parseInt(index, 10))) {
                product.setAttribute('data-pp-visible', '');
            } else {
                product.removeAttribute('data-pp-visible');
            }
        });
    }

    const setControlVisibility = (totalProductCount, visibleProductCount) => {
        const controlContainerElement = document.querySelector('.related-content-list__controls');

        if (totalProductCount > visibleProductCount) {
            controlContainerElement.style.display = 'block';
        } else {
            controlContainerElement.style.display = 'none';
        }
    }
}

export default initScript;