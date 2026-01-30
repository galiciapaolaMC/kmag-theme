const initEpisodeFilters = () => {
    const grid_filters = document.querySelectorAll('.grid-filter .dropdown-label');
    const slider_filters = document.querySelectorAll('.slider-filter .dropdown-label');
    const farmerContainers = document.querySelectorAll('.farmer-container');

    if (!grid_filters.length && !slider_filters.length && !farmerContainers.length) {
        return;
    }

    const protocol = window.location.protocol;
    const hostname = window.location.hostname;
    const restBase = protocol + '//' + hostname + '/wp-json/episode-grid-rest/v1';
    const restBaseSlider = protocol + '//' + hostname + '/wp-json/episode-slider-rest/v1';
    const restBaseAudioSlider = protocol + '//' + hostname + '/wp-json/episode-slider-audio-rest/v1';
    const restFarmerBase = protocol + '//' + hostname + '/wp-json/farmer-grid-rest/v1';
    const viewMore = document.querySelector('#view-more-farmers');

    if (grid_filters) {
        grid_filters.forEach((filter) => {
            filter.addEventListener('click', () => {
                const dropdown = filter.nextElementSibling;
                dropdown.classList.toggle('hidden');
            });
        });

        const applyButtons = document.querySelectorAll('.apply-wrapper-grid input[type="submit"]');
        
        if (applyButtons) {
            applyButtons.forEach((applyButton) => {
                applyButton.addEventListener('click', () => {
                    const selectedFiltersSeason = [];
                    const selectedFiltersAgronomy = [];

                    const seasonFilters = document.querySelectorAll('.grid-filter input[type="checkbox"][name="episode-season"]:checked');
                    const agronomyFilters = document.querySelectorAll('.grid-filter input[type="checkbox"][name="agronomy-topic"]:checked');
                    
                    seasonFilters.forEach((filter) => {
                        selectedFiltersSeason.push(filter.value);
                    });

                    agronomyFilters.forEach((filter) => {
                        selectedFiltersAgronomy.push(filter.value);
                    });

                    const selectedSeason = [...new Set(selectedFiltersSeason)];
                    const selectedAgronomy = [...new Set(selectedFiltersAgronomy)];

                    getFilteredCards(selectedSeason, selectedAgronomy);

                    document.querySelectorAll('.dropdown-wrapper').forEach((filter) => {
                        filter.classList.add('hidden');
                    });
                });
            });
        }
    }

    if (slider_filters) {
        slider_filters.forEach((filter) => {
            filter.addEventListener('click', () => {
                const dropdown = filter.nextElementSibling;
                dropdown.classList.toggle('hidden');
            });
        });

        const applyButtons = document.querySelectorAll('.apply-wrapper-slider input[type="submit"]');
        
        if (applyButtons) {
            applyButtons.forEach((applyButton) => {
                applyButton.addEventListener('click', () => {
                    const selectedFiltersSeason = [];
                    const selectedFiltersAgronomy = [];
                    const selefctedFiltersFarmers = [];
                    const selectedFiltersCountry = [];

                    const seasonFilters = document.querySelectorAll('.slider-filter input[type="checkbox"][name="episode-season"]:checked');
                    const agronomyFilters = document.querySelectorAll('.slider-filter input[type="checkbox"][name="agronomy-topic"]:checked');
                    const farmersFilters = document.querySelectorAll('.slider-filter input[type="checkbox"][name="farmer"]:checked');
                    const countryFilters = document.querySelectorAll('.slider-filter input[type="checkbox"][name="episode-country"]:checked');
                    
                    seasonFilters.forEach((filter) => {
                        selectedFiltersSeason.push(filter.value);
                    });

                    agronomyFilters.forEach((filter) => {
                        selectedFiltersAgronomy.push(filter.value);
                    });

                    farmersFilters.forEach((filter) => {
                        selefctedFiltersFarmers.push(filter.value);
                    });

                    countryFilters.forEach((filter) => {
                        selectedFiltersCountry.push(filter.value);
                    });

                    const selectedSeason = [...new Set(selectedFiltersSeason)];
                    const selectedAgronomy = [...new Set(selectedFiltersAgronomy)];
                    const selectedFarmers = [...new Set(selefctedFiltersFarmers)];
                    const selectedCountries = [...new Set(selectedFiltersCountry)];

                    getSliderVideoFilteredCards(selectedSeason, selectedAgronomy, selectedFarmers, selectedCountries);
                    getSliderAudioFilteredCards(selectedSeason, selectedAgronomy, selectedFarmers, selectedCountries);

                    if (selectedFiltersCountry.length > 0) {
                        getSliderFarmerFilteredCards(selectedCountries);
                    }

                    document.querySelectorAll('.dropdown-wrapper').forEach((filter) => {
                        filter.classList.add('hidden');
                    });
                });
            });
        }
    }

    if (farmerContainers) {
        viewMore.addEventListener('click', () => {
            farmerContainers.forEach((farmer) => {
                farmer.classList.remove('uk-hidden');
            });

            viewMore.style.display = 'none';
        });
    }

    function getFilteredCards(selectedSeason, selectedAgronomy) {
        const nonce = document.querySelector('input[name="nonce"]').value;

        var data = {
            season: selectedSeason,
            agronomy_topic: selectedAgronomy
        };

        const options = {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-WP-Nonce': nonce,
            },
            credentials: 'same-origin',
            body: JSON.stringify({
              data: data,
            }),
        };

        fetch(restBase + '/search', options)
        .then((response) => {
            if (!response.ok) {
                const statusError = 'Error getting Search from API';
                console.log(statusError);
                console.log(response);
            }
            return response.json();
        })
        .then((response) => {
            if (response.posts !== '') {
                setTimeout(function () {
                    const target = document.querySelector('.grid-filter-container');
                    target.innerHTML = response.posts;
                }, 200);
            } else {
                setTimeout(function () {
                    const target = document.querySelector('.grid-filter-container');
                    target.innerHTML = '<p>No results found.</p>';
                }, 200);
            }
        })
        .catch((response) => {
            console.log(response);
        });
    }

    function getSliderVideoFilteredCards(selectedSeason, selectedAgronomy, selectedFarmers, selectedCountries) {
        const nonce = document.querySelector('input[name="nonce"]').value;

        var data = {
            season: selectedSeason,
            agronomy_topic: selectedAgronomy,
            farmers: selectedFarmers,
            countries: selectedCountries
        };

        const options = {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-WP-Nonce': nonce,
            },
            credentials: 'same-origin',
            body: JSON.stringify({
              data: data,
            }),
        };

        fetch(restBaseSlider + '/search', options)
        .then((response) => {
            if (!response.ok) {
                const statusError = 'Error getting Search from API';
                console.log(statusError);
                console.log(response);
            }
            return response.json();
        })
        .then((response) => {
            if (response.posts !== '') {
                setTimeout(function () {
                    const target = document.querySelector('.video-filter-container');
                    target.innerHTML = response.posts;
                }, 200);
            } else {
                setTimeout(function () {
                    const target = document.querySelector('.video-filter-container');
                    target.innerHTML = '<p>No results found.</p>';
                }, 200);
            }
        })
        .catch((response) => {
            console.log(response);
        });
    }

    function getSliderAudioFilteredCards(selectedSeason, selectedAgronomy, selectedFarmers, selectedCountries) {
        const nonce = document.querySelector('input[name="nonce"]').value;
        
        var data = {
            season: selectedSeason,
            agronomy_topic: selectedAgronomy,
            farmers: selectedFarmers,
            countries: selectedCountries
        };

        const options = {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-WP-Nonce': nonce,
            },
            credentials: 'same-origin',
            body: JSON.stringify({
              data: data,
            }),
        };

        fetch(restBaseAudioSlider + '/search', options)
        .then((response) => {
            if (!response.ok) {
                const statusError = 'Error getting Search from API';
                console.log(statusError);
                console.log(response);
            }
            return response.json();
        })
        .then((response) => {
            if (response.posts !== '') {
                setTimeout(function () {
                    const target = document.querySelector('.audio-filter-container');
                    target.innerHTML = response.posts;
                }, 200);
            } else {
                setTimeout(function () {
                    const target = document.querySelector('.audio-filter-container');
                    target.innerHTML = '<p>No results found.</p>';
                }, 200);
            }
        })
        .catch((response) => {
            console.log(response);
        });
    }

    function getSliderFarmerFilteredCards(selectedCountries) {
        const nonce = document.querySelector('input[name="nonce"]').value;
        
        var data = {
            countries: selectedCountries
        };

        const options = {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-WP-Nonce': nonce,
            },
            credentials: 'same-origin',
            body: JSON.stringify({
              data: data,
            }),
        };

        fetch(restFarmerBase + '/search', options)
        .then((response) => {
            if (!response.ok) {
                const statusError = 'Error getting Search from API';
                console.log(statusError);
                console.log(response);
            }
            return response.json();
        })
        .then((response) => {
            document.querySelector("#view-more-farmers").style.display = 'none';
            if (response.posts !== '') {
                setTimeout(function () {
                    const target = document.querySelector('.farmer-filter-container');
                    target.innerHTML = response.posts;
                }, 200);
            } else {
                setTimeout(function () {
                    const target = document.querySelector('.farmer-filter-container');
                    target.innerHTML = '<p>No results found.</p>';
                }, 200);
            }
        })
        .catch((response) => {
            console.log(response);
        });
    }
};

export default initEpisodeFilters;
