if (typeof console != "undefined")
    if (typeof console.log != "undefined") console.olog = console.log;
    else console.olog = function() {};

console.log = function(message) {
    console.olog(message);
    document.getElementById("debugDiv").innerHTML += "<p>" + message + "</p>";
};
console.error = console.debug = console.info = console.log;
const video = document.getElementById("video");

const client = mqtt.connect("ws://127.0.0.1:1884");

client.on("connect", function() {
    client.subscribe("abcent");
});

let abcent = "false";

client.on("message", function(topic, message) {
    // message is Buffer
    abcent = message.toString();
    clearInterval(detection_time);
    detection_time = null;
});

client.stream.on("error", function(error) {
    console.error(error);
    window.location.reload(true);
});

function startVideo() {
    navigator.mediaDevices
        .getUserMedia({
            audio: false,
            video: {
                facingMode: "user",
                width: { ideal: 4096 },
                height: { ideal: 2160 }
            }
        })
        .then(
            stream => (video.srcObject = stream),
            err => console.log(err)
        );
}

const loadData = async () => {
    return await fetch("/api/getFaces")
        .then(response => response.json())
        .then(data => {
            return data;
        });
};

let setting = {};

const loadLabels = async () => {
    const data = await loadData();

    return Promise.all(
        data.data.map(async element => {
            const descriptions = [];
            const img = await faceapi.fetchImage(`${element.photo}`);
            const detections = await faceapi
                .detectSingleFace(img)
                .withFaceLandmarks()
                .withFaceDescriptor();
            descriptions.push(detections.descriptor);

            if (element.photo2) {
                const img2 = await faceapi.fetchImage(`${element.photo2}`);

                const detections2 = await faceapi
                    .detectSingleFace(img2)
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                descriptions.push(detections2.descriptor);
            }

            const predict = element;
            setting = data.setting;
            return new faceapi.LabeledFaceDescriptors(
                JSON.stringify(predict),
                descriptions
            );
        })
    ).catch(e => {
        window.location.reload(true);
    });
};

async function postData(url = "", data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
            "Content-Type": "application/json"
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
}

let timeout;
let detection_time = null;
function detectionTime() {
    let startTime = Date.now();
    if (!detection_time) {
        detection_time = setInterval(function() {
            let elapsedTime = Date.now() - startTime;
            document.getElementById("detection_time").innerHTML =
                (elapsedTime / 1000).toFixed(3) + " s";
        }, 100);
    }
}

function setCard() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        document.getElementById("name").innerHTML = "-";
        document.getElementById("nik").innerHTML = "-";
        document.getElementById("face").src = "/assets/images/no-image.png";
        document.getElementById("gender").innerHTML = "-";
        document.getElementById("alert").style.opacity = 1;
        document.getElementById("time").innerHTML = "-";
        document.getElementById("late").innerHTML = "-";
        document.getElementById("waktu_pulang").innerHTML = "-";
        document.getElementById("alert").style.opacity = 0;
        document.getElementById("detection_time").innerHTML = "-";
        client.publish("abcent", "false");
    }, 5000);
}

const countOccurrences = (arr, val) =>
    arr.reduce((a, v) => (v === val ? a + 1 : a), 0);

Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri("/face-recognition/models"),
    faceapi.nets.faceLandmark68Net.loadFromUri("/face-recognition/models"),
    faceapi.nets.faceRecognitionNet.loadFromUri("/face-recognition/models"),
    faceapi.nets.faceExpressionNet.loadFromUri("/face-recognition/models"),
    // faceapi.nets.ageGenderNet.loadFromUri("/face-recognition/models"),
    faceapi.nets.ssdMobilenetv1.loadFromUri("/face-recognition/models")
])
    .then(startVideo)
    .catch(e => {
        window.location.reload(true);
    });

let labelCount = [];

video.addEventListener("play", async () => {
    const canvas = faceapi.createCanvasFromMedia(video);
    const canvasSize = {
        width: video.width,
        height: video.height
    };
    const labels = await loadLabels();
    faceapi.matchDimensions(canvas, canvasSize);
    document.body.appendChild(canvas);
    setInterval(async () => {
        const detections = await faceapi
            .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceExpressions()
            // .withAgeAndGender()
            .withFaceDescriptors();
        const resizedDetections = faceapi.resizeResults(detections, canvasSize);
        const faceMatcher = new faceapi.FaceMatcher(labels, 0.45);
        const results = resizedDetections.map(d =>
            faceMatcher.findBestMatch(d.descriptor)
        );
        canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
        faceapi.draw.drawDetections(canvas, resizedDetections);
        // faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
        // faceapi.draw.drawFaceExpressions(canvas, resizedDetections);
        // resizedDetections.forEach((detection) => {
        //   const { age, gender, genderProbability } = detection;
        //   new faceapi.draw.DrawTextField(
        //     [
        //       `${parseInt(age, 10)} years`,
        //       `${gender} (${parseInt(genderProbability * 100, 10)})`,
        //     ],
        //     detection.detection.box.topRight
        //   ).draw(canvas);
        // });

        if (abcent === "true") {
            detectionTime();
            results.forEach((result, index) => {
                const box = resizedDetections[index].detection.box;
                const { label, distance } = result;
                labelCount.push(label);
                // console.log(label);
                // console.log(labelCount);
                const detectCount = countOccurrences(labelCount, label);
                const detectUnknownCount = countOccurrences(
                    labelCount,
                    "unknown"
                );
                if (labelCount.length > 10) {
                    if (detectCount > detectUnknownCount) {
                        const predict = JSON.parse(label);
                        const time = new Date();
                        console.log(detection_time);
                        document.getElementById("name").innerHTML =
                            predict.name;
                        document.getElementById("nik").innerHTML = predict.nim;
                        document.getElementById("face").src = predict.photo;
                        document.getElementById("gender").innerHTML =
                            predict.gender;
                        document.getElementById("alert").style.opacity = 1;
                        postData("/api/abcent", { id: predict.id }).then(
                            data => {
                                document.getElementById("time").innerHTML =
                                    data.data.arrival;
                                document.getElementById(
                                    "waktu_pulang"
                                ).innerHTML = data.data.waktu_pulang;
                                document.getElementById("late").innerHTML =
                                    data.data.late === 1;
                                setCard();
                                client.publish("abcent", "stop2");
                            }
                        );
                    }
                    labelCount = [];
                }
                // new faceapi.draw.DrawTextField(
                //     [`${label} (${parseInt(distance * 100, 10)})`],
                //     // [`${label}`],
                //     box.bottomRight
                // ).draw(canvas);
            });
        }
    }, 100);
});
