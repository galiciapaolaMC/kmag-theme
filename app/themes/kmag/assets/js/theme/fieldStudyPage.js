import mapboxgl from "mapbox-gl";
const initFieldStudyPage = () => {
  if (!document.getElementById("field-study-map")) {
    return;
  }
  const MAPBOX_API_KEY = window?.field_study?.maps_api_key ?? null;
  const GOOGLE_STORAGE_URL = window?.field_study?.google_storage_url ?? null;
  mapboxgl.accessToken = MAPBOX_API_KEY;

  const urlParams = new URLSearchParams(window.location.search);
  const fieldId = urlParams.get("id");
  const geoJsonUrl = GOOGLE_STORAGE_URL;
  const map = new mapboxgl.Map({
    container: "field-study-map",
    style: "mapbox://styles/mapbox/satellite-v9",
    center: [-94.875717, 44.092047],
    zoom: 15,
  });
  function convertPointToCoordinates(pointString) {
    const match = pointString.match(/POINT\(([^)]+)\)/);
    if (match && match[1]) {
      const [longitude, latitude] = match[1].split(" ").map(Number);
      return [longitude, latitude];
    }
    return null;
  }

  map.on("load", function () {
    fetch(geoJsonUrl)
      .then((response) => response.json())
      .then((allData) => {
        const fieldData = allData[fieldId];
        if (!fieldData) {
          console.error("Field data not found for ID:", fieldId);
          return;
        }
        if (fieldData.coordinates) {
          const centerCoordinates = convertPointToCoordinates(
            fieldData.coordinates
          );
          if (centerCoordinates) {
            map.setCenter(centerCoordinates);
            map.setZoom(15);
          } else {
            console.error("Invalid coordinates format:", fieldData.coordinates);
          }
        } else {
          console.error("Coordinates not found in field data");
        }
        const zoneData = fieldData["Field Boundary"].zone;
        if (!zoneData || !zoneData.features) {
          console.error("Invalid or missing zone data");
          return;
        }

        const bounds = new mapboxgl.LngLatBounds();

        zoneData.features.forEach((feature) => {
          feature.geometry.coordinates[0].forEach((coord) => {
            bounds.extend(coord);
          });
        });

        map.fitBounds(bounds, { padding: 20 });

        map.addSource("zone", {
          type: "geojson",
          data: zoneData,
        });

        map.addLayer({
          id: "zones",
          type: "fill",
          source: "zone",
          layout: {},
          paint: {
            "fill-color": [
              "match",
              ["get", "product_name"],
              "Grower standard practice",
              "#FF0000",
              "#00FF00",
            ],
            "fill-opacity": 0.3,
          },
        });
      })
      .catch((error) => console.error("Error loading GeoJSON data:", error));
  });

  map.scrollZoom.disable();
  map.boxZoom.disable();
  map.dragRotate.disable();
  map.dragPan.disable();
  map.keyboard.disable();
  map.doubleClickZoom.disable();
  map.touchZoomRotate.disable();
};

export default initFieldStudyPage;