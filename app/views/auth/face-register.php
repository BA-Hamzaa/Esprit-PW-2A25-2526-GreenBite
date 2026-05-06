<div class="container py-12">
    <div class="card max-w-2xl mx-auto p-8 text-center">
        <h1 class="text-3xl font-bold mb-4" style="font-family:var(--font-heading); color:var(--primary)">
            Enregistrement Face ID
        </h1>
        <p class="text-gray-600 mb-8">
            Scannez votre visage pour pouvoir vous connecter sans mot de passe à l'avenir.
            <br><small>Assurez-vous d'être dans un endroit bien éclairé.</small>
        </p>

        <div id="video-container" class="relative mx-auto rounded-xl overflow-hidden shadow-lg bg-gray-100" style="width:400px; height:300px; display:flex; align-items:center; justify-content:center;">
            <div id="loading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-100 z-10">
                <i data-lucide="loader-2" class="animate-spin text-primary w-12 h-12 mb-4"></i>
                <p>Chargement de l'IA faciale...</p>
            </div>
            <video id="video" width="400" height="300" autoplay muted class="object-cover w-full h-full" style="display:none;"></video>
            <canvas id="overlay" class="absolute top-0 left-0 w-full h-full z-20 pointer-events-none"></canvas>
        </div>

        <div class="mt-8">
            <button id="capture-btn" class="btn btn-primary btn-lg" disabled>
                <i data-lucide="camera"></i> Analyser mon visage
            </button>
            <p id="status-msg" class="mt-4 text-sm font-medium"></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", async () => {
    const video = document.getElementById('video');
    const loading = document.getElementById('loading');
    const captureBtn = document.getElementById('capture-btn');
    const statusMsg = document.getElementById('status-msg');
    const overlay = document.getElementById('overlay');
    
    // Load models from CDN
    const MODEL_URL = 'https://cdn.jsdelivr.net/gh/justadudewhohacks/face-api.js@master/weights';
    
    try {
        await Promise.all([
            faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL)
        ]);
        
        loading.style.display = 'none';
        video.style.display = 'block';
        captureBtn.disabled = false;
        
        startVideo();
    } catch (e) {
        statusMsg.textContent = "Erreur de chargement des modèles IA.";
        statusMsg.style.color = 'red';
        console.error(e);
    }

    function startVideo() {
        navigator.mediaDevices.getUserMedia({ video: {} })
            .then(stream => { video.srcObject = stream; })
            .catch(err => {
                statusMsg.textContent = "Veuillez autoriser l'accès à la caméra.";
                statusMsg.style.color = 'red';
            });
    }

    video.addEventListener('play', () => {
        const displaySize = { width: video.width, height: video.height };
        faceapi.matchDimensions(overlay, displaySize);
        
        setInterval(async () => {
            if(video.paused || video.ended) return;
            const detections = await faceapi.detectAllFaces(video).withFaceLandmarks();
            const resizedDetections = faceapi.resizeResults(detections, displaySize);
            const ctx = overlay.getContext('2d');
            ctx.clearRect(0, 0, overlay.width, overlay.height);
            faceapi.draw.drawDetections(overlay, resizedDetections);
        }, 100);
    });

    captureBtn.addEventListener('click', async () => {
        captureBtn.disabled = true;
        statusMsg.textContent = "Analyse en cours...";
        statusMsg.style.color = 'var(--text-secondary)';
        
        const detections = await faceapi.detectSingleFace(video).withFaceLandmarks().withFaceDescriptor();
        
        if (!detections) {
            statusMsg.textContent = "Aucun visage détecté. Veuillez vous placer bien en face.";
            statusMsg.style.color = 'red';
            captureBtn.disabled = false;
            return;
        }

        const descriptor = Array.from(detections.descriptor);
        
        // Send to server
        fetch('<?= BASE_URL ?>/?page=api-face-register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ descriptor })
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                statusMsg.textContent = "Face ID enregistré avec succès !";
                statusMsg.style.color = 'green';
                setTimeout(() => window.location.href = '<?= BASE_URL ?>/', 2000);
            } else {
                statusMsg.textContent = data.error || "Une erreur est survenue.";
                statusMsg.style.color = 'red';
                captureBtn.disabled = false;
            }
        })
        .catch(err => {
            statusMsg.textContent = "Erreur de communication avec le serveur.";
            statusMsg.style.color = 'red';
            captureBtn.disabled = false;
        });
    });
});
</script>
