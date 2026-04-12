<!-- eslint-disable curly -->
<!-- eslint-disable import/order -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
// eslint-disable-next-line @typescript-eslint/no-unused-vars
import { Head, useForm, usePage } from '@inertiajs/vue3';
//------------------------------------------------------------basic ui comps frm shadcn
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
// eslint-disable-next-line @typescript-eslint/no-unused-vars
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
//------------------------------------------------------------routed
import { template } from '@/routes';
import mem from '@/extra/mem.js';
//------------------------------------------------------------code starts here

// access page info such as user
const page = usePage();
// replace 'complaint' with real object
interface Props {
    complaint: object,
}
const props = defineProps<Props>();

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const form = ref({
    user_id: page.props.auth.user.email,
    name: page.props.auth.user.email,
});

onMounted(() => { // invoked when page ready
    // Vanilla JS: Get a URL parameter
    const params = new URLSearchParams(window.location.search);
    const userId = params.get('id');
    console.log("User ID from URL:", userId); // If the URL is /products?category=electronics&sort=price

    form.value = { ...form.value, ...props.complaint }; // merge key:value pair
    form.value.name = page.props.auth.user.email;
    console.log("Garry Cacho ", page.props.auth.user.email);

    console.log("Mapped ");

    mem.register("garrycachi_searchList", searchList);
    mem.register("garrycachi_customerID", customerID);

    // initialize map
    initialMap.value = L.map("map", {
        maxZoom: 23,
        minZoom: 6,
        zoomControl: false
    }).setView(
        coopMainCoordinates,
        initialMapZoom,
    );
    L.control.zoom({
        position: 'bottomleft'
    }).addTo(initialMap.value);
    // this prevents zoom animation error, part of map setup
    L.Popup.prototype._animateZoom = (e) => {
        if (!initialMap.value._map) {
            return;
        }

        const pos = initialMap.value._map._latLngToNewLayerPoint(
            initialMap.value._latlng,
            e.zoom,
            e.center
        ),
            anchor = initialMap.value._getAnchor();
        L.DomUtil.setPosition(initialMap.value._container, pos.add(anchor));
    };

    // opening the 'Modal Start Loading Data Animation' form
    // checking if all geoJSON is downloaded
    // if so, close the 'Modal Start Loading Data Animation'
    // and draw on map the subtrans line, pole and power xmers
    checkIfAllDataAreDownloaded(() => {
        layer2.value = L.geoJson(rawSubtranspoleData.value, {
            pointToLayer: (feature, latlng) => {
                return L.circleMarker(latlng, {
                    radius: 7,
                    fillColor: "#447855",
                    color: "#000",
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8,
                });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PoleID +
                    "</b><br>" +
                    feature.properties.StructureType1 +
                    "<br>" +
                    feature.properties.PoleType +
                    "<br>" +
                    feature.properties.Height +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer2.value.addTo(initialMap.value);

        layer7.value = L.geoJson(rawSubtranslineData.value, {
            style: {
                color: "yellow",
                weight: 7,
                opacity: 0.95,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PhaseCondSize +
                    " " +
                    feature.properties.PhaseCondType +
                    " " +
                    feature.properties.PhaseCondStrands +
                    " " +
                    feature.properties.PhaseCondUnit +
                    "</b><br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.length
                );
            },
        });
        layer7.value.addTo(initialMap.value);

        layer9.value = L.geoJson(rawSubtransXmerData.value, {
            pointToLayer: (feature, latlng) => {
                return L.marker(latlng, {
                    icon: L.icon({
                        iconUrl: "powerxmer.png",
                        iconSize: [30, 30], // size of the icon
                        shadowSize: [30, 20], // size of the shadow
                        iconAnchor: [0, 0], // point of the icon which will correspond to marker's location
                        shadowAnchor: [0, 0], // the same for the shadow
                        popupAnchor: [15, -1], // point from which the popup should open relative to the iconAnchor
                    }),
                });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.XmerID +
                    "</b><br>" +
                    feature.properties.KVA +
                    " kVA" +
                    "<br>" +
                    feature.properties.percentZ +
                    "% Impedance" +
                    "<br>" +
                    feature.properties.KVp +
                    "/" +
                    feature.properties.KVs +
                    " kV" +
                    "<br>" +
                    feature.properties.Brand +
                    "<br>" +
                    feature.properties.Model +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer9.value.addTo(initialMap.value);

        //loginexampleModal.value = new bootstrap.Modal(document.getElementById("loginexampleModal")); // creating modal object
        //loginexampleModal.value.show();
    });

    const crosshair = new L.marker(initialMap.value.getCenter(), {
        icon: L.icon({
            iconUrl: 'crosshair.png',
            iconSize: [50, 50], // size of the icon
            iconAnchor: [25, 25], // point of the icon which will correspond to marker's location
        }), clickable: false
    });
    crosshair.addTo(initialMap.value);

    setInterval(() => {
        //var currentPos =initialMap.value.getCenter();
        crosshair.setLatLng(initialMap.value.getCenter());
        /*
        initialMap.value.panTo([
                                 currentPos.lat,
                                 currentPos.lng
                                ]);
                                */
    }, 250);

    // just trying to test the on movend,
    // it is called after the map is panned or zoomed
    initialMap.value.on("moveend", () => {
        const databounds = initialMap.value.getBounds();
        console.log(databounds._southWest.lat); //min lat
        console.log(databounds._southWest.lng); //min lng
        console.log(databounds._northEast.lat); //max lat
        console.log(databounds._northEast.lng); //max lng
        console.log(initialMap.value.getZoom());
        crosshair.setLatLng(initialMap.value.getCenter());
        gpsStuck.value = false;
    });

    // add hybrid google map tile
    L.tileLayer(googleLayerMap, {
        maxZoom: 30,
    }).addTo(initialMap.value);

    // create a gps marker
    gpsMarker.value[0] = L.circle(
        [11.015566682201666, 123.9924500087559]
        ,
        {
            color: "yellow",
            radius: 5,
            fillColor: "steelblue",
            opacity: 0.5,
        }
    );
    gpsMarker.value[1] = L.marker([11.015566682201666, 123.9924500087559], {
        icon: L.icon({
            iconUrl: "standing_man.png",
            iconSize: [60, 40], // size of the icon
            shadowSize: [30, 20], // size of the shadow
            iconAnchor: [30, 40], // point of the icon which will correspond to marker's location
            shadowAnchor: [30, 40], // the same for the shadow
        }),
    });
    gpsMarker.value[0].addTo(initialMap.value);
    gpsMarker.value[1].addTo(initialMap.value);

    // monitor the gps position and update the gps marker to correstpond
    // to the current gps location
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition((position) => {
            gps.value = position;
            gpsMarker.value[0].setLatLng(L.latLng(gps.value.coords.latitude, gps.value.coords.longitude));
            gpsMarker.value[1].setLatLng(L.latLng(gps.value.coords.latitude, gps.value.coords.longitude));
        });
    }

    // start of downloading of geoJSON Files
    fetch("mapassets/map1/map1_cons.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawCustomerData.value = data;
        });

    fetch("mapassets/map1/map1_subtranspole.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawSubtranspoleData.value = data;
        });

    fetch("mapassets/map1/map1_pripole.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawPripoleData.value = data;
        });

    fetch("mapassets/map1/map1_secpole.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawSecpoleData.value = data;
        });

    fetch("mapassets/map1/map1_secline.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawSeclineData.value = data;
        });

    fetch("mapassets/map1/map1_priline.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawPrilineData.value = data;
        });

    fetch("mapassets/map1/map1_distxmer.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawDistxmerData.value = data;
        });

    fetch("mapassets/map1/map1_subtransline.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawSubtranslineData.value = data;
        });

    fetch("mapassets/map1/map1_powerxmer.geojson")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawSubtransXmerData.value = data;
        });

    fetch("data/users.json")
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            rawUsersData.value = data;
        });
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Map',
                href: template(),
            },
        ],
    },
});

//--------------------------------------------------------------------------- navigation-menu
// eslint-disable-next-line @typescript-eslint/no-unused-vars
import { CircleCheckIcon, CircleHelpIcon, CircleIcon } from 'lucide-vue-next'
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
} from '@/components/ui/navigation-menu';

//--------------------------------------------------------------------------- dialog
import {
    Dialog,
    // eslint-disable-next-line @typescript-eslint/no-unused-vars
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';

//---------------------------------------------------------------------------//
const googleLayerMap = "https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}"; //
const initialMapZoom = 19;                                                   //
const coopMainCoordinates = [11.0155, 123.9924];                             // ylat, xlon format
//---------------------------------------------------------------------------//

//--------------------------------------------------------------map leaflet
import * as L from "leaflet";
import { uid } from "uid";
import { Icon } from '@iconify/vue';

const showConfirmDelete = ref(null);
const deleteAll = ref(null);
const searchList = ref([]);
const error_message = ref(null);
const loading = ref(null);
const gps = ref(null);
const gpsStuck = ref(null);
const gpsMarker = ref([]);
const rawUsersData = ref(null);
const rawCustomerData = ref(null);
const rawPrilineData = ref(null);
const rawPripoleData = ref(null);
const rawSubtranspoleData = ref(null);
const rawSubtranslineData = ref(null);
const rawSubtransXmerData = ref(null);
const rawSeclineData = ref(null);
const rawSecpoleData = ref(null);
const rawDistxmerData = ref(null);
const rawSavedCustomerFeaturesData = ref([]);
const rawSavedPrilineFeaturesData = ref([]);
const rawSavedPripoleFeaturesData = ref([]);
const rawSavedSeclineFeaturesData = ref([]);
const rawSavedSecpoleFeaturesData = ref([]);
const rawSavedDistxmerFeaturesData = ref(null);
const filteredCustomerData = ref(null);
const initialMap = ref(null);
const layer1 = ref(null);
const layer2 = ref(null);
const layer3 = ref(null);
const layer4 = ref(null);
const layer5 = ref(null);
const layer6 = ref(null);
const layer7 = ref(null);
const layer8 = ref(null);
const layer9 = ref(null);
const customerID = ref(null);

const openSearchFilterHistoryDialog = ref(false);

const searchHistoryModal = () => {
    deleteAll.value = "";
    openSearchFilterHistoryDialog.value = true;
    showConfirmDelete.value = false;
};

const listOfCustomerFeatures = () => {
    rawSavedCustomerFeaturesData.value = [];

    for (let i = 0; i < rawCustomerData.value.features.length; i++) {
        rawSavedCustomerFeaturesData.value.push(rawCustomerData.value.features[i]);
    }

    filteredCustomerData.value = rawCustomerData.value;
    filteredCustomerData.value.features = [];
    let foundFeatureGeometry = null;

    for (let i = 0; i < rawSavedCustomerFeaturesData.value.length; i++) {
        const feature = rawSavedCustomerFeaturesData.value[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (
                    feature.properties.JAEDType == "VarLoad" &&
                    feature.properties.CustomerID === customerID.value
                ) {
                    foundFeatureGeometry = feature.geometry;
                    L.circle(
                        {
                            lat: foundFeatureGeometry.coordinates[1],
                            lng: foundFeatureGeometry.coordinates[0],
                        },
                        {
                            color: "yellow",
                            radius: 5,
                            fillColor: "steelblue",
                            opacity: 0.5,
                        }
                    ).addTo(initialMap.value);
                    const tempMarker = L.marker([
                        foundFeatureGeometry.coordinates[1],
                        foundFeatureGeometry.coordinates[0],
                    ]).addTo(initialMap.value);
                    const popup = L.popup().setContent(
                        "<b>" +
                        feature.properties.CustomerID +
                        "</b><br>" +
                        feature.properties.CustomerName +
                        "<br>" +
                        feature.properties.Address +
                        "<br>" +
                        "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                        feature.geometry.coordinates[1] +
                        "," +
                        feature.geometry.coordinates[0] +
                        "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                    );
                    tempMarker.bindPopup(popup).openPopup();
                    break;
                }
    }

    if (foundFeatureGeometry) {
        for (let i = 0; i < rawSavedCustomerFeaturesData.value.length; i++) {
            const feature = rawSavedCustomerFeaturesData.value[i];

            if (feature.properties)

                if (feature.properties.JAEDType)

                    if (feature.properties.JAEDType == "VarLoad") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt(
                            (x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1)
                        );

                        if (distance < 0.0006) {
                            // approximately 50 meters
                            filteredCustomerData.value.features.push(feature);
                        }
                    }
        }

        layer1.value = L.geoJson(filteredCustomerData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: "#ff7800",
                        color: "yellow",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.9,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.CustomerID +
                    "</b><br>" +
                    feature.properties.CustomerName +
                    "<br>" +
                    feature.properties.Address +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer1.value.addTo(initialMap.value);

        rawSavedSeclineFeaturesData.value = [];

        for (let i = 0; i < rawSeclineData.value.features.length; i++) {
            rawSavedSeclineFeaturesData.value.push(rawSeclineData.value.features[i]);
        }

        rawSeclineData.value.features = [];

        for (let i = 0; i < rawSavedSeclineFeaturesData.value.length; i++) {
            const feature = rawSavedSeclineFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "LVLine") {
                        const x2 = feature.geometry.coordinates[0][0];
                        const y2 = feature.geometry.coordinates[0][1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawSeclineData.value.features.push(feature);
                        }
                    }
        }

        layer5.value = L.geoJson(rawSeclineData.value, {
            style: {
                color: "#ff1144",
                weight: 3,
                opacity: 0.65,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PhaseCondSize +
                    " " +
                    feature.properties.PhaseCondType +
                    " " +
                    feature.properties.PhaseCondStrands +
                    " " +
                    feature.properties.PhaseCondUnit +
                    "</b><br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.length
                );
            },
        });
        layer5.value.addTo(initialMap.value);
        rawSeclineData.value.features = rawSavedSeclineFeaturesData.value;

        rawSavedSecpoleFeaturesData.value = [];

        for (let i = 0; i < rawSecpoleData.value.features.length; i++) {
            rawSavedSecpoleFeaturesData.value.push(rawSecpoleData.value.features[i]);
        }

        rawSecpoleData.value.features = [];

        for (let i = 0; i < rawSavedSecpoleFeaturesData.value.length; i++) {
            const feature = rawSavedSecpoleFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "LVPole") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawSecpoleData.value.features.push(feature);
                        }
                    }
        }

        layer4.value = L.geoJson(rawSecpoleData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: "#ff1188",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PoleID +
                    "</b><br>" +
                    feature.properties.StructureType1 +
                    "<br>" +
                    feature.properties.PoleType +
                    "<br>" +
                    feature.properties.Height +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer4.value.addTo(initialMap.value);
        rawSecpoleData.value.features = rawSavedSecpoleFeaturesData.value;

        rawSavedPrilineFeaturesData.value = [];

        for (let i = 0; i < rawPrilineData.value.features.length; i++) {
            rawSavedPrilineFeaturesData.value.push(rawPrilineData.value.features[i]);
        }

        rawPrilineData.value.features = [];

        for (let i = 0; i < rawSavedPrilineFeaturesData.value.length; i++) {
            const feature = rawSavedPrilineFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "MVLine") {
                        const x2 = feature.geometry.coordinates[0][0];
                        const y2 = feature.geometry.coordinates[0][1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawPrilineData.value.features.push(feature);
                        }
                    }
        }

        layer6.value = L.geoJson(rawPrilineData.value, {
            style: {
                color: "#ff7800",
                weight: 5,
                opacity: 0.65,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PhaseCondSize +
                    " " +
                    feature.properties.PhaseCondType +
                    " " +
                    feature.properties.PhaseCondStrands +
                    " " +
                    feature.properties.PhaseCondUnit +
                    "</b><br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.length
                );
            },
        });
        layer6.value.addTo(initialMap.value);
        rawPrilineData.value.features = rawSavedPrilineFeaturesData.value;

        rawSavedPripoleFeaturesData.value = [];

        for (let i = 0; i < rawPripoleData.value.features.length; i++) {
            rawSavedPripoleFeaturesData.value.push(rawPripoleData.value.features[i]);
        }

        rawPripoleData.value.features = [];

        for (let i = 0; i < rawSavedPripoleFeaturesData.value.length; i++) {
            const feature = rawSavedPripoleFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "MVPole") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawPripoleData.value.features.push(feature);
                        }
                    }
        }

        layer3.value = L.geoJson(rawPripoleData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 8,
                        fillColor: "#ff7800",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PoleID +
                    "</b><br>" +
                    feature.properties.StructureType1 +
                    "<br>" +
                    feature.properties.PoleType +
                    "<br>" +
                    feature.properties.Height +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer3.value.addTo(initialMap.value);
        rawPripoleData.value.features = rawSavedPripoleFeaturesData.value;

        rawSavedDistxmerFeaturesData.value = [];

        for (let i = 0; i < rawDistxmerData.value.features.length; i++) {
            rawSavedDistxmerFeaturesData.value.push(
                rawDistxmerData.value.features[i]
            );
        }

        rawDistxmerData.value.features = [];

        for (let i = 0; i < rawSavedDistxmerFeaturesData.value.length; i++) {
            const feature = rawSavedDistxmerFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "DistXmer") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawDistxmerData.value.features.push(feature);
                        }
                    }
        }

        layer8.value = L.geoJson(rawDistxmerData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 12,
                        fillColor: "#221100",
                        color: "#000",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.9,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.Serial +
                    " / " +
                    feature.properties.CoopID +
                    "</b><br>" +
                    feature.properties.XmerID +
                    "<br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.xKVA +
                    "kVA<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer8.value.addTo(initialMap.value);
        rawDistxmerData.value.features = rawSavedDistxmerFeaturesData.value;

        // zoom to found customer
        initialMap.value.eachLayer((layer) => {
            if (layer.feature)
                if (layer.feature.properties)
                    if (layer.feature.properties.JAEDType)
                        if (
                            layer.feature.properties.JAEDType === "VarLoad" &&
                            layer.feature.properties.CustomerID === customerID.value
                        ) {
                            console.log("Found: ");
                            console.log(layer.feature.properties.CustomerID);
                            console.log(layer.feature.geometry.coordinates[1]);
                            console.log(layer.feature.geometry.coordinates[0]);
                            console.log(layer.feature.properties.CustomerName);
                            console.log(layer.feature.properties.Address);
                            console.log(layer.feature.properties.CustomerType);
                            loading.value = false;
                            console.log("Ang naka fale kay si hcustomersearch");
                            initialMap.value.flyTo(
                                new L.LatLng(
                                    layer.feature.geometry.coordinates[1],
                                    layer.feature.geometry.coordinates[0]
                                ),
                                19
                            );
                        }
        });
    }

    rawCustomerData.value.features = rawSavedCustomerFeaturesData.value;
};

const poleSearch = () => {
    rawSavedCustomerFeaturesData.value = [];

    for (let i = 0; i < rawCustomerData.value.features.length; i++) {
        rawSavedCustomerFeaturesData.value.push(rawCustomerData.value.features[i]);
    }

    filteredCustomerData.value = rawCustomerData.value;
    filteredCustomerData.value.features = [];

    let foundPriFeatureGeometry = null;
    let foundSecFeatureGeometry = null;

    for (let i = 0; i < rawSecpoleData.value.features.length; i++) {
        const feature = rawSecpoleData.value.features[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (
                    feature.properties.JAEDType == "LVPole" &&
                    feature.properties.PoleID === customerID.value
                ) {
                    foundSecFeatureGeometry = feature.geometry;
                    const tempMarker = L.marker([
                        foundSecFeatureGeometry.coordinates[1],
                        foundSecFeatureGeometry.coordinates[0],
                    ]).addTo(initialMap.value);
                    const popup = L.popup().setContent(
                        "<b>" +
                        feature.properties.PoleID +
                        "</b><br>" +
                        feature.properties.StructureType1 +
                        "<br>" +
                        feature.properties.PoleType +
                        "<br>" +
                        feature.properties.Height +
                        "<br>" +
                        "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                        feature.geometry.coordinates[1] +
                        "," +
                        feature.geometry.coordinates[0] +
                        "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                    );
                    tempMarker.bindPopup(popup).openPopup();
                    break;
                }
    }

    for (let i = 0; i < rawPripoleData.value.features.length; i++) {
        const feature = rawPripoleData.value.features[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (
                    feature.properties.JAEDType == "MVPole" &&
                    feature.properties.PoleID === customerID.value
                ) {
                    foundPriFeatureGeometry = feature.geometry;
                    const tempMarker = L.marker([
                        foundPriFeatureGeometry.coordinates[1],
                        foundPriFeatureGeometry.coordinates[0],
                    ]).addTo(initialMap.value);
                    const popup = L.popup().setContent(
                        "<b>" +
                        feature.properties.PoleID +
                        "</b><br>" +
                        feature.properties.StructureType1 +
                        "<br>" +
                        feature.properties.PoleType +
                        "<br>" +
                        feature.properties.Height +
                        "<br>" +
                        "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                        feature.geometry.coordinates[1] +
                        "," +
                        feature.geometry.coordinates[0] +
                        "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                    );
                    tempMarker.bindPopup(popup).openPopup();
                    break;
                }
    }

    let foundFeatureGeometry = null;

    if (foundPriFeatureGeometry || foundSecFeatureGeometry) {
        if (foundPriFeatureGeometry) {
            foundFeatureGeometry = foundPriFeatureGeometry;
        } else {
            foundFeatureGeometry = foundSecFeatureGeometry;
        }

        for (let i = 0; i < rawSavedCustomerFeaturesData.value.length; i++) {
            const feature = rawSavedCustomerFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "VarLoad") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt(
                            (x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1)
                        );

                        if (distance < 0.0011) {
                            // approximately 100 meters
                            filteredCustomerData.value.features.push(feature);
                        }
                    }
        }

        layer1.value = L.geoJson(filteredCustomerData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: "#ff7800",
                        color: "yellow",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.9,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.CustomerID +
                    "</b><br>" +
                    feature.properties.CustomerName +
                    "<br>" +
                    feature.properties.Address +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer1.value.addTo(initialMap.value);
        rawCustomerData.value.features = rawSavedCustomerFeaturesData.value;

        rawSavedSeclineFeaturesData.value = [];

        for (let i = 0; i < rawSeclineData.value.features.length; i++) {
            rawSavedSeclineFeaturesData.value.push(rawSeclineData.value.features[i]);
        }

        rawSeclineData.value.features = [];

        for (let i = 0; i < rawSavedSeclineFeaturesData.value.length; i++) {
            const feature = rawSavedSeclineFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "LVLine") {
                        const x2 = feature.geometry.coordinates[0][0];
                        const y2 = feature.geometry.coordinates[0][1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawSeclineData.value.features.push(feature);
                        }
                    }
        }

        layer5.value = L.geoJson(rawSeclineData.value, {
            style: {
                color: "#ff1144",
                weight: 3,
                opacity: 0.65,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PhaseCondSize +
                    " " +
                    feature.properties.PhaseCondType +
                    " " +
                    feature.properties.PhaseCondStrands +
                    " " +
                    feature.properties.PhaseCondUnit +
                    "</b><br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.length
                );
            },
        });
        layer5.value.addTo(initialMap.value);
        rawSeclineData.value.features = rawSavedSeclineFeaturesData.value;

        rawSavedSecpoleFeaturesData.value = [];

        for (let i = 0; i < rawSecpoleData.value.features.length; i++) {
            rawSavedSecpoleFeaturesData.value.push(rawSecpoleData.value.features[i]);
        }

        rawSecpoleData.value.features = [];

        for (let i = 0; i < rawSavedSecpoleFeaturesData.value.length; i++) {
            const feature = rawSavedSecpoleFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "LVPole") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawSecpoleData.value.features.push(feature);
                        }
                    }
        }

        layer4.value = L.geoJson(rawSecpoleData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: "#ff1188",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PoleID +
                    "</b><br>" +
                    feature.properties.StructureType1 +
                    "<br>" +
                    feature.properties.PoleType +
                    "<br>" +
                    feature.properties.Height +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer4.value.addTo(initialMap.value);
        rawSecpoleData.value.features = rawSavedSecpoleFeaturesData.value;

        rawSavedPrilineFeaturesData.value = [];

        for (let i = 0; i < rawPrilineData.value.features.length; i++) {
            rawSavedPrilineFeaturesData.value.push(rawPrilineData.value.features[i]);
        }

        rawPrilineData.value.features = [];

        for (let i = 0; i < rawSavedPrilineFeaturesData.value.length; i++) {
            const feature = rawSavedPrilineFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "MVLine") {
                        const x2 = feature.geometry.coordinates[0][0];
                        const y2 = feature.geometry.coordinates[0][1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawPrilineData.value.features.push(feature);
                        }
                    }
        }

        layer6.value = L.geoJson(rawPrilineData.value, {
            style: {
                color: "#ff7800",
                weight: 5,
                opacity: 0.65,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PhaseCondSize +
                    " " +
                    feature.properties.PhaseCondType +
                    " " +
                    feature.properties.PhaseCondStrands +
                    " " +
                    feature.properties.PhaseCondUnit +
                    "</b><br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.length
                );
            },
        });
        layer6.value.addTo(initialMap.value);
        rawPrilineData.value.features = rawSavedPrilineFeaturesData.value;

        rawSavedPripoleFeaturesData.value = [];

        for (let i = 0; i < rawPripoleData.value.features.length; i++) {
            rawSavedPripoleFeaturesData.value.push(rawPripoleData.value.features[i]);
        }

        rawPripoleData.value.features = [];

        for (let i = 0; i < rawSavedPripoleFeaturesData.value.length; i++) {
            const feature = rawSavedPripoleFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "MVPole") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawPripoleData.value.features.push(feature);
                        }
                    }
        }

        layer3.value = L.geoJson(rawPripoleData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 8,
                        fillColor: "#ff7800",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PoleID +
                    "</b><br>" +
                    feature.properties.StructureType1 +
                    "<br>" +
                    feature.properties.PoleType +
                    "<br>" +
                    feature.properties.Height +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer3.value.addTo(initialMap.value);
        rawPripoleData.value.features = rawSavedPripoleFeaturesData.value;

        rawSavedDistxmerFeaturesData.value = [];

        for (let i = 0; i < rawDistxmerData.value.features.length; i++) {
            rawSavedDistxmerFeaturesData.value.push(
                rawDistxmerData.value.features[i]
            );
        }

        rawDistxmerData.value.features = [];

        for (let i = 0; i < rawSavedDistxmerFeaturesData.value.length; i++) {
            const feature = rawSavedDistxmerFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "DistXmer") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawDistxmerData.value.features.push(feature);
                        }
                    }
        }

        layer8.value = L.geoJson(rawDistxmerData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 12,
                        fillColor: "#221100",
                        color: "#000",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.9,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.Serial +
                    " / " +
                    feature.properties.CoopID +
                    "</b><br>" +
                    feature.properties.XmerID +
                    "<br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.xKVA +
                    "kVA<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer8.value.addTo(initialMap.value);
        rawDistxmerData.value.features = rawSavedDistxmerFeaturesData.value;

        // zoom to found customer
        initialMap.value.eachLayer((layer) => {
            if (layer.feature)
                if (layer.feature.properties)
                    if (layer.feature.properties.JAEDType)
                        if (layer.feature.properties.PoleID === customerID.value) {
                            console.log("Found: ");
                            console.log(layer.feature.properties.PoleID);
                            console.log(layer.feature.geometry.coordinates[1]);
                            console.log(layer.feature.geometry.coordinates[0]);
                            console.log(layer.feature.properties.CustomerName);
                            loading.value = false;
                            console.log("Ang naka fale kay si hpole search");
                            initialMap.value.flyTo(
                                new L.LatLng(
                                    layer.feature.geometry.coordinates[1],
                                    layer.feature.geometry.coordinates[0]
                                ),
                                19
                            );
                        }
        });
    }
};

const xmerSearch = () => {
    let foundDistxmerFeatureGeometry = null;

    for (let i = 0; i < rawDistxmerData.value.features.length; i++) {
        const feature = rawDistxmerData.value.features[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (
                    feature.properties.JAEDType === "DistXmer" &&
                    (feature.properties.Serial === customerID.value ||
                        feature.properties.XmerID === customerID.value ||
                        feature.properties.CoopID === customerID.value)
                ) {
                    foundDistxmerFeatureGeometry = feature.geometry;

                    const tempMarker = L.marker([
                        foundDistxmerFeatureGeometry.coordinates[1],
                        foundDistxmerFeatureGeometry.coordinates[0],
                    ]).addTo(initialMap.value);
                    const popup = L.popup().setContent(
                        "<b>" +
                        feature.properties.Serial +
                        " / " +
                        feature.properties.CoopID +
                        "</b><br>" +
                        feature.properties.XmerID +
                        "<br>" +
                        feature.properties.Phase +
                        "<br>" +
                        feature.properties.xKVA +
                        "kVA<br>" +
                        "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                        feature.geometry.coordinates[1] +
                        "," +
                        feature.geometry.coordinates[0] +
                        "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                    );
                    tempMarker.bindPopup(popup).openPopup();
                    break;
                }
    }

    if (foundDistxmerFeatureGeometry) {
        const foundFeatureGeometry = foundDistxmerFeatureGeometry;
        rawSavedCustomerFeaturesData.value = [];

        for (let i = 0; i < rawCustomerData.value.features.length; i++) {
            rawSavedCustomerFeaturesData.value.push(
                rawCustomerData.value.features[i]
            );
        }

        filteredCustomerData.value = rawCustomerData.value;
        filteredCustomerData.value.features = [];

        for (let i = 0; i < rawSavedCustomerFeaturesData.value.length; i++) {
            const feature = rawSavedCustomerFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "VarLoad") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt(
                            (x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1)
                        );

                        if (distance < 0.0011) {
                            // approximately 100 meters
                            filteredCustomerData.value.features.push(feature);
                        }
                    }
        }

        layer1.value = L.geoJson(filteredCustomerData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: "#ff7800",
                        color: "yellow",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.9,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.CustomerID +
                    "</b><br>" +
                    feature.properties.CustomerName +
                    "<br>" +
                    feature.properties.Address +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer1.value.addTo(initialMap.value);
        rawCustomerData.value.features = rawSavedCustomerFeaturesData.value;

        rawSavedSeclineFeaturesData.value = [];

        for (let i = 0; i < rawSeclineData.value.features.length; i++) {
            rawSavedSeclineFeaturesData.value.push(rawSeclineData.value.features[i]);
        }

        rawSeclineData.value.features = [];

        for (let i = 0; i < rawSavedSeclineFeaturesData.value.length; i++) {
            const feature = rawSavedSeclineFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "LVLine") {
                        const x2 = feature.geometry.coordinates[0][0];
                        const y2 = feature.geometry.coordinates[0][1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawSeclineData.value.features.push(feature);
                        }
                    }
        }

        layer5.value = L.geoJson(rawSeclineData.value, {
            style: {
                color: "#ff1144",
                weight: 3,
                opacity: 0.65,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PhaseCondSize +
                    " " +
                    feature.properties.PhaseCondType +
                    " " +
                    feature.properties.PhaseCondStrands +
                    " " +
                    feature.properties.PhaseCondUnit +
                    "</b><br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.length
                );
            },
        });
        layer5.value.addTo(initialMap.value);
        rawSeclineData.value.features = rawSavedSeclineFeaturesData.value;

        rawSavedSecpoleFeaturesData.value = [];

        for (let i = 0; i < rawSecpoleData.value.features.length; i++) {
            rawSavedSecpoleFeaturesData.value.push(rawSecpoleData.value.features[i]);
        }

        rawSecpoleData.value.features = [];

        for (let i = 0; i < rawSavedSecpoleFeaturesData.value.length; i++) {
            const feature = rawSavedSecpoleFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "LVPole") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawSecpoleData.value.features.push(feature);
                        }
                    }
        }

        layer4.value = L.geoJson(rawSecpoleData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 6,
                        fillColor: "#ff1188",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PoleID +
                    "</b><br>" +
                    feature.properties.StructureType1 +
                    "<br>" +
                    feature.properties.PoleType +
                    "<br>" +
                    feature.properties.Height +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer4.value.addTo(initialMap.value);
        rawSecpoleData.value.features = rawSavedSecpoleFeaturesData.value;

        rawSavedPrilineFeaturesData.value = [];

        for (let i = 0; i < rawPrilineData.value.features.length; i++) {
            rawSavedPrilineFeaturesData.value.push(rawPrilineData.value.features[i]);
        }

        rawPrilineData.value.features = [];

        for (let i = 0; i < rawSavedPrilineFeaturesData.value.length; i++) {
            const feature = rawSavedPrilineFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "MVLine") {
                        const x2 = feature.geometry.coordinates[0][0];
                        const y2 = feature.geometry.coordinates[0][1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawPrilineData.value.features.push(feature);
                        }
                    }
        }

        layer6.value = L.geoJson(rawPrilineData.value, {
            style: {
                color: "#ff7800",
                weight: 5,
                opacity: 0.65,
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PhaseCondSize +
                    " " +
                    feature.properties.PhaseCondType +
                    " " +
                    feature.properties.PhaseCondStrands +
                    " " +
                    feature.properties.PhaseCondUnit +
                    "</b><br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.length
                );
            },
        });
        layer6.value.addTo(initialMap.value);
        rawPrilineData.value.features = rawSavedPrilineFeaturesData.value;

        rawSavedPripoleFeaturesData.value = [];

        for (let i = 0; i < rawPripoleData.value.features.length; i++) {
            rawSavedPripoleFeaturesData.value.push(rawPripoleData.value.features[i]);
        }

        rawPripoleData.value.features = [];

        for (let i = 0; i < rawSavedPripoleFeaturesData.value.length; i++) {
            const feature = rawSavedPripoleFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "MVPole") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawPripoleData.value.features.push(feature);
                        }
                    }
        }

        layer3.value = L.geoJson(rawPripoleData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 8,
                        fillColor: "#ff7800",
                        color: "#000",
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.PoleID +
                    "</b><br>" +
                    feature.properties.StructureType1 +
                    "<br>" +
                    feature.properties.PoleType +
                    "<br>" +
                    feature.properties.Height +
                    "<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer3.value.addTo(initialMap.value);
        rawPripoleData.value.features = rawSavedPripoleFeaturesData.value;

        rawSavedDistxmerFeaturesData.value = [];

        for (let i = 0; i < rawDistxmerData.value.features.length; i++) {
            rawSavedDistxmerFeaturesData.value.push(
                rawDistxmerData.value.features[i]
            );
        }

        rawDistxmerData.value.features = [];

        for (let i = 0; i < rawSavedDistxmerFeaturesData.value.length; i++) {
            const feature = rawSavedDistxmerFeaturesData.value[i];

            if (feature.properties)
                if (feature.properties.JAEDType)
                    if (feature.properties.JAEDType == "DistXmer") {
                        const x2 = feature.geometry.coordinates[0];
                        const y2 = feature.geometry.coordinates[1];
                        const x1 = foundFeatureGeometry.coordinates[0];
                        const y1 = foundFeatureGeometry.coordinates[1];
                        const distance = Math.sqrt((x2 - x1) * (x2 - x1) + (y2 - y1) * (y2 - y1));

                        if (distance < 0.006) {
                            // approximately 500 meters
                            rawDistxmerData.value.features.push(feature);
                        }
                    }
        }

        layer8.value = L.geoJson(rawDistxmerData.value, {
            pointToLayer: (feature, latlng) => {
                if (latlng)
                    return L.circleMarker(latlng, {
                        radius: 12,
                        fillColor: "#221100",
                        color: "#000",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.9,
                    });
            },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(
                    "<b>" +
                    feature.properties.Serial +
                    " / " +
                    feature.properties.CoopID +
                    "</b><br>" +
                    feature.properties.XmerID +
                    "<br>" +
                    feature.properties.Phase +
                    "<br>" +
                    feature.properties.xKVA +
                    "kVA<br>" +
                    "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                    feature.geometry.coordinates[1] +
                    "," +
                    feature.geometry.coordinates[0] +
                    "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                );
            },
        });
        layer8.value.addTo(initialMap.value);
        rawDistxmerData.value.features = rawSavedDistxmerFeaturesData.value;

        // zoom to found customer
        initialMap.value.eachLayer((layer) => {
            if (layer.feature)
                if (layer.feature.properties)
                    if (layer.feature.properties.JAEDType)
                        if (
                            layer.feature.properties.Serial === customerID.value ||
                            layer.feature.properties.XmerID === customerID.value ||
                            layer.feature.properties.CoopID === customerID.value
                        ) {
                            console.log("Found: ");
                            console.log(layer.feature.properties.XmerID);
                            console.log(layer.feature.geometry.coordinates[1]);
                            console.log(layer.feature.geometry.coordinates[0]);
                            console.log(layer.feature.properties.xKVA);
                            loading.value = false;
                            console.log("Ang naka fale kay si xmerar");
                            initialMap.value.flyTo(
                                new L.LatLng(
                                    layer.feature.geometry.coordinates[1],
                                    layer.feature.geometry.coordinates[0]
                                ),
                                19
                            );
                        }
        });
    }
};

const hvpoleSearch = () => {
    let foundSubtranspoleFeatureGeometry = null;

    for (let i = 0; i < rawSubtranspoleData.value.features.length; i++) {
        const feature = rawSubtranspoleData.value.features[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (
                    feature.properties.JAEDType == "HVPole" &&
                    feature.properties.PoleID === customerID.value
                ) {
                    foundSubtranspoleFeatureGeometry = feature.geometry;
                    const tempMarker = L.marker([
                        foundSubtranspoleFeatureGeometry.coordinates[1],
                        foundSubtranspoleFeatureGeometry.coordinates[0],
                    ]).addTo(initialMap.value);
                    const popup = L.popup().setContent(
                        "<b>" +
                        feature.properties.PoleID +
                        "</b><br>" +
                        feature.properties.StructureType1 +
                        "<br>" +
                        feature.properties.PoleType +
                        "<br>" +
                        feature.properties.Height +
                        "<br>" +
                        "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                        feature.geometry.coordinates[1] +
                        "," +
                        feature.geometry.coordinates[0] +
                        "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
                    );
                    tempMarker.bindPopup(popup).openPopup();
                    break;
                }
    }

    if (foundSubtranspoleFeatureGeometry) {
        // zoom to found customer
        initialMap.value.eachLayer((layer) => {
            if (layer.feature)
                if (layer.feature.properties)
                    if (layer.feature.properties.JAEDType)
                        if (layer.feature.properties.PoleID === customerID.value) {
                            console.log("Found: ");
                            console.log(layer.feature.properties.PoleID);
                            console.log(layer.feature.geometry.coordinates[1]);
                            console.log(layer.feature.geometry.coordinates[0]);
                            loading.value = false;
                            console.log("Ang naka fale kay si hvpole");
                            initialMap.value.flyTo(
                                new L.LatLng(
                                    layer.feature.geometry.coordinates[1],
                                    layer.feature.geometry.coordinates[0]
                                ),
                                19
                            );
                        }
        });
    }
};

const showAllCustomersHere = () => {
    loading.value = true;
    setTimeout(showAllCustomersHere1, 100);
};

const showAllCustomersHere1 = () => {

    const databounds = initialMap.value.getBounds();

    rawSavedCustomerFeaturesData.value = [];

    for (let i = 0; i < rawCustomerData.value.features.length; i++) {
        rawSavedCustomerFeaturesData.value.push(rawCustomerData.value.features[i]);
    }

    filteredCustomerData.value = rawCustomerData.value;
    filteredCustomerData.value.features = [];

    for (let i = 0; i < rawSavedCustomerFeaturesData.value.length; i++) {
        const feature = rawSavedCustomerFeaturesData.value[i];
        if (feature.properties)
            if (feature.properties.JAEDType)
                if (feature.properties.JAEDType == "VarLoad") {
                    var x2 = feature.geometry.coordinates[0];
                    var y2 = feature.geometry.coordinates[1];
                    var miny1 = databounds._southWest.lat;
                    const minx1 = databounds._southWest.lng;
                    const maxy1 = databounds._northEast.lat;
                    const maxx1 = databounds._northEast.lng;

                    if (minx1 < x2 && x2 <= maxx1 && miny1 < y2 && y2 <= maxy1) {
                        filteredCustomerData.value.features.push(feature);
                    }
                }
    }

    layer1.value = L.geoJson(filteredCustomerData.value, {
        pointToLayer: (feature, latlng) => {
            if (latlng)
                return L.circleMarker(latlng, {
                    radius: 6,
                    fillColor: "#ff7800",
                    color: "yellow",
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.9,
                });
        },
        onEachFeature: (feature, layer) => {
            layer.bindPopup(
                "<b>" +
                feature.properties.CustomerID +
                "</b><br>" +
                feature.properties.CustomerName +
                "<br>" +
                feature.properties.Address +
                "<br>" +
                "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                feature.geometry.coordinates[1] +
                "," +
                feature.geometry.coordinates[0] +
                "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
            );
        },
    });
    layer1.value.addTo(initialMap.value);
    rawCustomerData.value.features = rawSavedCustomerFeaturesData.value;
    loading.value = false;
    //closeOffCanvasMenu();
};

const checkoutThisPlace = () => {
    loading.value = true;
    setTimeout(checkoutThisPlace1, 100);
};

const checkoutThisPlace1 = () => {
    const databounds = initialMap.value.getBounds();
    rawSavedSeclineFeaturesData.value = [];

    for (let i = 0; i < rawSeclineData.value.features.length; i++) {
        rawSavedSeclineFeaturesData.value.push(rawSeclineData.value.features[i]);
    }

    rawSeclineData.value.features = [];

    for (let i = 0; i < rawSavedSeclineFeaturesData.value.length; i++) {
        const feature = rawSavedSeclineFeaturesData.value[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (feature.properties.JAEDType == "LVLine") {
                    const x2 = feature.geometry.coordinates[0][0];
                    const y2 = feature.geometry.coordinates[0][1];
                    const miny1 = databounds._southWest.lat;
                    const minx1 = databounds._southWest.lng;
                    const maxy1 = databounds._northEast.lat;
                    const maxx1 = databounds._northEast.lng;

                    if (minx1 < x2 && x2 <= maxx1 && miny1 < y2 && y2 <= maxy1) {
                        rawSeclineData.value.features.push(feature);
                    }
                }
    }

    layer5.value = L.geoJson(rawSeclineData.value, {
        style: {
            color: "#ff1144",
            weight: 3,
            opacity: 0.65,
        },
        onEachFeature: (feature, layer) => {
            layer.bindPopup(
                "<b>" +
                feature.properties.PhaseCondSize +
                " " +
                feature.properties.PhaseCondType +
                " " +
                feature.properties.PhaseCondStrands +
                " " +
                feature.properties.PhaseCondUnit +
                "</b><br>" +
                feature.properties.Phase +
                "<br>" +
                feature.properties.length
            );
        },
    });
    layer5.value.addTo(initialMap.value);
    rawSeclineData.value.features = rawSavedSeclineFeaturesData.value;

    rawSavedSecpoleFeaturesData.value = [];

    for (let i = 0; i < rawSecpoleData.value.features.length; i++) {
        rawSavedSecpoleFeaturesData.value.push(rawSecpoleData.value.features[i]);
    }

    rawSecpoleData.value.features = [];

    for (let i = 0; i < rawSavedSecpoleFeaturesData.value.length; i++) {
        const feature = rawSavedSecpoleFeaturesData.value[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (feature.properties.JAEDType == "LVPole") {
                    const x2 = feature.geometry.coordinates[0];
                    const y2 = feature.geometry.coordinates[1];
                    const miny1 = databounds._southWest.lat;
                    const minx1 = databounds._southWest.lng;
                    const maxy1 = databounds._northEast.lat;
                    const maxx1 = databounds._northEast.lng;

                    if (minx1 < x2 && x2 <= maxx1 && miny1 < y2 && y2 <= maxy1) {
                        rawSecpoleData.value.features.push(feature);
                    }
                }
    }

    layer4.value = L.geoJson(rawSecpoleData.value, {
        pointToLayer: (feature, latlng) => {
            if (latlng)
                return L.circleMarker(latlng, {
                    radius: 6,
                    fillColor: "#ff1188",
                    color: "#000",
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8,
                });
        },
        onEachFeature: (feature, layer) => {
            layer.bindPopup(
                "<b>" +
                feature.properties.PoleID +
                "</b><br>" +
                feature.properties.StructureType1 +
                "<br>" +
                feature.properties.PoleType +
                "<br>" +
                feature.properties.Height +
                "<br>" +
                "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                feature.geometry.coordinates[1] +
                "," +
                feature.geometry.coordinates[0] +
                "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
            );
        },
    });
    layer4.value.addTo(initialMap.value);
    rawSecpoleData.value.features = rawSavedSecpoleFeaturesData.value;

    rawSavedPrilineFeaturesData.value = [];

    for (let i = 0; i < rawPrilineData.value.features.length; i++) {
        rawSavedPrilineFeaturesData.value.push(rawPrilineData.value.features[i]);
    }

    rawPrilineData.value.features = [];

    for (let i = 0; i < rawSavedPrilineFeaturesData.value.length; i++) {
        const feature = rawSavedPrilineFeaturesData.value[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (feature.properties.JAEDType == "MVLine") {
                    const x2 = feature.geometry.coordinates[0][0];
                    const y2 = feature.geometry.coordinates[0][1];
                    const miny1 = databounds._southWest.lat;
                    const minx1 = databounds._southWest.lng;
                    const maxy1 = databounds._northEast.lat;
                    const maxx1 = databounds._northEast.lng;

                    if (minx1 < x2 && x2 <= maxx1 && miny1 < y2 && y2 <= maxy1) {
                        rawPrilineData.value.features.push(feature);
                    }
                }
    }

    layer6.value = L.geoJson(rawPrilineData.value, {
        style: {
            color: "#ff7800",
            weight: 5,
            opacity: 0.65,
        },
        onEachFeature: (feature, layer) => {
            layer.bindPopup(
                "<b>" +
                feature.properties.PhaseCondSize +
                " " +
                feature.properties.PhaseCondType +
                " " +
                feature.properties.PhaseCondStrands +
                " " +
                feature.properties.PhaseCondUnit +
                "</b><br>" +
                feature.properties.Phase +
                "<br>" +
                feature.properties.length
            );
        },
    });
    layer6.value.addTo(initialMap.value);
    rawPrilineData.value.features = rawSavedPrilineFeaturesData.value;

    rawSavedPripoleFeaturesData.value = [];

    for (let i = 0; i < rawPripoleData.value.features.length; i++) {
        rawSavedPripoleFeaturesData.value.push(rawPripoleData.value.features[i]);
    }

    rawPripoleData.value.features = [];

    for (let i = 0; i < rawSavedPripoleFeaturesData.value.length; i++) {
        const feature = rawSavedPripoleFeaturesData.value[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (feature.properties.JAEDType == "MVPole") {
                    const x2 = feature.geometry.coordinates[0];
                    const y2 = feature.geometry.coordinates[1];
                    const miny1 = databounds._southWest.lat;
                    const minx1 = databounds._southWest.lng;
                    const maxy1 = databounds._northEast.lat;
                    const maxx1 = databounds._northEast.lng;

                    if (minx1 < x2 && x2 <= maxx1 && miny1 < y2 && y2 <= maxy1) {
                        rawPripoleData.value.features.push(feature);
                    }
                }
    }

    layer3.value = L.geoJson(rawPripoleData.value, {
        pointToLayer: (feature, latlng) => {
            if (latlng)
                return L.circleMarker(latlng, {
                    radius: 8,
                    fillColor: "#ff7800",
                    color: "#000",
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8,
                });
        },
        onEachFeature: (feature, layer) => {
            layer.bindPopup(
                "<b>" +
                feature.properties.PoleID +
                "</b><br>" +
                feature.properties.StructureType1 +
                "<br>" +
                feature.properties.PoleType +
                "<br>" +
                feature.properties.Height +
                "<br>" +
                "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                feature.geometry.coordinates[1] +
                "," +
                feature.geometry.coordinates[0] +
                "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
            );
        },
    });
    layer3.value.addTo(initialMap.value);
    rawPripoleData.value.features = rawSavedPripoleFeaturesData.value;

    rawSavedDistxmerFeaturesData.value = [];

    for (let i = 0; i < rawDistxmerData.value.features.length; i++) {
        rawSavedDistxmerFeaturesData.value.push(rawDistxmerData.value.features[i]);
    }

    rawDistxmerData.value.features = [];

    for (let i = 0; i < rawSavedDistxmerFeaturesData.value.length; i++) {
        const feature = rawSavedDistxmerFeaturesData.value[i];

        if (feature.properties)
            if (feature.properties.JAEDType)
                if (feature.properties.JAEDType == "DistXmer") {
                    const x2 = feature.geometry.coordinates[0];
                    const y2 = feature.geometry.coordinates[1];
                    const miny1 = databounds._southWest.lat;
                    const minx1 = databounds._southWest.lng;
                    const maxy1 = databounds._northEast.lat;
                    const maxx1 = databounds._northEast.lng;

                    if (minx1 < x2 && x2 <= maxx1 && miny1 < y2 && y2 <= maxy1) {
                        rawDistxmerData.value.features.push(feature);
                    }
                }
    }

    layer8.value = L.geoJson(rawDistxmerData.value, {
        pointToLayer: (feature, latlng) => {
            if (latlng)
                return L.circleMarker(latlng, {
                    radius: 12,
                    fillColor: "#221100",
                    color: "#000",
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.9,
                });
        },
        onEachFeature: (feature, layer) => {
            layer.bindPopup(
                "<b>" +
                feature.properties.Serial +
                " / " +
                feature.properties.CoopID +
                "</b><br>" +
                feature.properties.XmerID +
                "<br>" +
                feature.properties.Phase +
                "<br>" +
                feature.properties.xKVA +
                "kVA<br>" +
                "<a target='_blank' href='https://www.google.com/maps?q&layer=c&cbll=" +
                feature.geometry.coordinates[1] +
                "," +
                feature.geometry.coordinates[0] +
                "&cbp=0,0,0,0,0&z=18'>StreetView</a>"
            );
        },
    });
    layer8.value.addTo(initialMap.value);
    rawDistxmerData.value.features = rawSavedDistxmerFeaturesData.value;
    loading.value = false;
    //closeOffCanvasMenu();
};

const customerSearch = () => {
    if (customerID.value && customerID.value.length > 0) {
        loading.value = true;
        error_message.value = "";
        setTimeout(customerSearch1, 100);
    } else {
        error_message.value = "Error: Search key cannot be empty...";
    }
}

const searchkeyClick = (string_value) => {
    customerID.value = string_value;
    customerSearch();
    openSearchFilterHistoryDialog.value = false;
};

const customerSearch1 = () => {
    let searchIsUnique = true;
    const date = new Date();
    const formatter = new Intl.DateTimeFormat('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    const formattedDate = formatter.format(date);
    loading.value = true;

    if (customerID.value.includes("ST")) hvpoleSearch();

    else if (customerID.value.includes("C")) poleSearch();

    else if (customerID.value.includes("T")) xmerSearch();

    else listOfCustomerFeatures();

    if (!loading.value) {
        // found
        //closeOffCanvasMenu();
        error_message.value = "";

        for (let i = 0; i < searchList.value.length; i++) { // check if search key is unique before saving
            if (searchList.value[i].string_value === customerID.value) {
                searchIsUnique = false;
            }
        }

        if (searchIsUnique)
            searchList.value.push({
                id: uid(),
                string_value: customerID.value,
                found: true,
                data: formattedDate,
            });
    } else {
        // not found
        error_message.value = "Error: Search key not found...";
        loading.value = false;
        console.log("searching not found");

        for (let i = 0; i < searchList.value.length; i++) { // check if search key is unique before saving
            if (searchList.value[i].string_value === customerID.value) { searchIsUnique = false; };
        }

        console.log("searching not found - save key");

        if (searchIsUnique)
            searchList.value.push({
                id: uid(),
                string_value: customerID.value,
                found: false,
                data: formattedDate,
            });
    }
};

const whereAmILocatedClick = () => {
    loading.value = true;
    setTimeout(whereAmILocatedClick1, 200);
}

const whereAmILocatedClick1 = () => {
    gpsStuck.value = true;

    if (initialMap.value && gps.value) {
        initialMap.value.flyTo([gps.value.coords.latitude, gps.value.coords.longitude], 18);
    }

    //closeOffCanvasMenu();
    loading.value = false;
};

const checkIfAllDataAreDownloaded = (afterDataIsLoaded) => {
    //const myModal = new bootstrap.Modal(document.getElementById("exampleModal")); // creating modal object
    //myModal.show();
    //check if all the geojson file is done downloading

    const refreshIntervalId = setInterval(() => {
        if (
            rawUsersData.value &&
            rawCustomerData.value &&
            rawPrilineData.value &&
            rawPripoleData.value &&
            rawSeclineData.value &&
            rawSecpoleData.value &&
            rawDistxmerData.value) {
            clearInterval(refreshIntervalId);
            setTimeout(() => {
                if (afterDataIsLoaded) afterDataIsLoaded();
                //myModal.hide();
            }, 2000);
        }
    }, 500);

};

const confirmClearClick = () => {
    showConfirmDelete.value = false;

    if (deleteAll.value === "delete all") {
        while (searchList.value.length > 0) {
            searchList.value.pop();
        }

        searchList.value = [];
    }

    deleteAll.value = "";
};

const clearHistoryClick = () => {
    showConfirmDelete.value = true;
};
</script>

<template>

    <Head title="Map" />

    <!-- Main Frame DIV -->
    <div class=" z-0 h-full w-full overflow-auto p-0 m-0 justify-center">

        <!-- Dialog for History of Search Filters -->
        <Dialog v-model:open="openSearchFilterHistoryDialog" class="h-screen">
            <DialogTrigger as-child>
            </DialogTrigger>
            <DialogContent class="w-full h-full">
                <DialogHeader>
                    <DialogTitle>Search Filter History</DialogTitle>
                    <DialogDescription>
                        These are the list of searches you entered ....
                    </DialogDescription>
                </DialogHeader>

                <!-- Dialog Body Start -->
                <div class="w-full flex flex-wrap gap-2 overflow-auto justify-center">
                    <div v-for="(searchkey) in searchList" :key="searchkey.id" class="w-[30%] p-2">
                        <Button class="flex flex-col border rounded-lg h-20 w-30 cursor-pointer"
                            @click="searchkeyClick(searchkey.string_value)">
                            <p><b>{{ searchkey.string_value }}</b></p>
                            <span style="font-size: 10px;">
                                <div class="flex flex-row">
                                    <Icon v-show="searchkey.found" icon="icon-park-outline:success" width="15px"
                                        height="15px" style="color: #271bf2" />
                                    <Icon v-show="!searchkey.found" icon="ep:failed" width="15px" height="15px"
                                        style="color: #eb0d0d" />
                                    {{ searchkey.data }}
                                </div>
                            </span>
                        </Button>
                    </div>
                </div>
                <!-- Dialog Body Ended -->

                <DialogFooter>
                    <Button class=" bg-red-500" @click="clearHistoryClick" v-show="!showConfirmDelete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-list-minus-icon lucide-list-minus">
                            <path d="M16 5H3" />
                            <path d="M11 12H3" />
                            <path d="M16 19H3" />
                            <path d="M21 12h-6" />
                        </svg>
                        Delete All
                    </Button>
                    <div class="flex flex-col gap-3 w-full" v-show="showConfirmDelete">
                        <label>Enter&nbsp;<span class=" font-bold text-red-600">delete all</span>&nbsp;to
                            confirm</label>
                        <div class="flex flex-row gap-3">
                            <Input class="w-full shadow-red-500" placeholder="ex. delete all"
                                v-model="deleteAll"></Input>
                            <Button class=" bg-red-500" @click="confirmClearClick">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-calendar-check2-icon lucide-calendar-check-2">
                                    <path d="M8 2v4" />
                                    <path d="M16 2v4" />
                                    <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                                    <path d="M3 10h18" />
                                    <path d="m16 20 2 2 4-4" />
                                </svg>
                                Confirm</Button>
                        </div>
                    </div>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <!-- Page Main Menu -->
        <div class=" absolute top-0 h-12 pt-3 z-50 flex w-[80%] sm:w-[400px]">
            <NavigationMenu :viewport="false" class="">
                <NavigationMenuList>
                    <NavigationMenuItem>
                        <NavigationMenuTrigger>Functions</NavigationMenuTrigger>
                        <NavigationMenuContent>
                            <ul class="grid w-full sm:w-[400px] gap-4">
                                <li><!-- Nav Separator -->
                                    <div class="flex-row items-center gap-2 border-t-2 w-full h-60 md:hidden"></div>
                                </li>
                                <li>
                                    <NavigationMenuLink as-child>
                                        <span class="flex-row items-center gap-2 cursor-pointer"
                                            @click="whereAmILocatedClick()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-map-pin-icon lucide-map-pin">
                                                <path
                                                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                            Where Am I
                                        </span>
                                    </NavigationMenuLink>
                                    <NavigationMenuLink as-child>
                                        <span class="flex-row items-center gap-2 cursor-pointer"
                                            @click="checkoutThisPlace()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-utility-pole-icon lucide-utility-pole">
                                                <path d="M12 2v20" />
                                                <path d="M2 5h20" />
                                                <path d="M3 3v2" />
                                                <path d="M7 3v2" />
                                                <path d="M17 3v2" />
                                                <path d="M21 3v2" />
                                                <path d="m19 5-7 7-7-7" />
                                            </svg>
                                            Checkout This Place
                                        </span>
                                    </NavigationMenuLink>
                                    <NavigationMenuLink as-child>
                                        <span class="flex-row items-center gap-2 cursor-pointer"
                                            @click="showAllCustomersHere()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-users-icon lucide-users">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                                <circle cx="9" cy="7" r="4" />
                                            </svg>
                                            Who Are In Here
                                        </span>
                                    </NavigationMenuLink>
                                    <NavigationMenuLink as-child>
                                        <span class="flex-row items-center gap-2 cursor-pointer"
                                            @click="searchHistoryModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-square-stack-icon lucide-square-stack">
                                                <path d="M4 10c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2" />
                                                <path d="M10 16c-1.1 0-2-.9-2-2v-4c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2" />
                                                <rect width="8" height="8" x="14" y="14" rx="2" />
                                            </svg>
                                            Show My Search History
                                        </span>
                                    </NavigationMenuLink>
                                </li>
                                <li><!-- Nav Separator -->
                                    <div class="flex-row items-center gap-2 border-t-2 w-full h-1"></div>
                                </li>
                                <li>
                                    <div class="flex flex-col lg:flex-row w-full">
                                        <div class="flex flex-col gap-2 w-full">
                                            <Label>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-funnel-icon lucide-funnel">
                                                    <path
                                                        d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                                                </svg>
                                                Search Filter
                                            </Label>
                                            <div class="flex flex-row w-full">
                                                <Input type="text" v-model="customerID"
                                                    class="rounder-none rounded-l-full w-full"
                                                    placeholder="ex. 847843" />
                                                <Button :disabled="loading"
                                                    class="rounder-none rounded-r-full cursor-pointer"
                                                    @click="customerSearch()">
                                                    <div v-show="!loading">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="lucide lucide-search-icon lucide-search">
                                                            <path d="m21 21-4.34-4.34" />
                                                            <circle cx="11" cy="11" r="8" />
                                                        </svg>
                                                    </div>
                                                    <div v-show="loading" class="animate-spin">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="lucide lucide-loader-circle-icon lucide-loader-circle">
                                                            <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                                                        </svg>
                                                    </div>
                                                </Button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="h-10"></div>
                                </li>
                            </ul>
                        </NavigationMenuContent>
                    </NavigationMenuItem>
                </NavigationMenuList>
            </NavigationMenu>
        </div>

        <!-- Form Frame -->
        <div class="z-10 p-0 m-0 flex flex-col w-full h-full">
            <!-- Main Content Start -->
            <div id="map" class="z-0 w-full h-full"></div>
            <!-- Main Content Ended -->
        </div>
    </div>
</template>
