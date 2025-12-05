<script setup>
import {ref, computed, onUnmounted, nextTick, watch} from 'vue';

// --- PROPS & EMITS ---
const props = defineProps({
    modelValue: {type: String, default: ''},
    users: {
        type: Array,
        default: () => ['Admin', 'Dev', 'Guest', 'Root', 'User1', 'User2', 'Tester']
    }
});

const emit = defineEmits(['update:modelValue']);

// --- CONSTANTES PHYSIQUES ---
const ACCEL = 0.2;
const FRICTION = 0.96;
const TURN_SPEED = 0.8;

// --- STATE ---
const gameActive = ref(false);
const message = ref('');
const viewport = ref(null);
const car = ref({x: 100, y: 110, angle: 90, speed: 0});
const keys = {ArrowUp: false, ArrowDown: false, ArrowLeft: false, ArrowRight: false, Enter: false, ' ': false};
const spots = ref([]);
const worldWidth = ref(5000);
const cameraX = ref(0);
let animationFrameId = null;

// --- LOGIQUE DU JEU ---

const initWorld = () => {
    const newSpots = [];
    const spotWidth = 100;

    // Génération dynamique basée sur les props
    const totalSpots = props.users.length + 10; // Quelques places vides

    for (let i = 0; i < totalSpots; i++) {
        const xPos = 400 + (i * spotWidth);

        // Assigner un utilisateur ou laisser vide
        const userName = i < props.users.length ? props.users[i] : 'Libre';

        newSpots.push({
            id: i,
            user: userName,
            x: xPos,
            rect: {
                x: xPos,
                y: 0, // Ajusté pour le layout
                w: 90,
                h: 130
            }
        });
    }
    spots.value = newSpots;
    worldWidth.value = 400 + (totalSpots * spotWidth) + 500;

    // Reset voiture
    car.value = {x: 50, y: 110, angle: 90, speed: 0};
    cameraX.value = 0;
};

const updatePhysics = () => {
    if (!gameActive.value) return;

    // Physique (similaire au prototype HTML)
    if (keys.ArrowUp) car.value.speed += ACCEL;
    if (keys.ArrowDown) car.value.speed -= ACCEL;
    if (keys[' ']) car.value.speed *= 0.9;
    car.value.speed *= FRICTION;

    if (Math.abs(car.value.speed) > 0.1) {
        const dir = keys.ArrowLeft ? -1 : (keys.ArrowRight ? 1 : 0);
        const reverseFactor = car.value.speed > 0 ? 1 : -1;
        car.value.angle += dir * TURN_SPEED * reverseFactor;
    }

    const rad = car.value.angle * (Math.PI / 180);
    car.value.x += Math.sin(rad) * car.value.speed;
    car.value.y += -Math.cos(rad) * car.value.speed;

    // Collisions Murs
    if (car.value.y < -50) {
        car.value.y = -50;
        car.value.speed *= -0.5;
    }
    if (car.value.y > 270) {
        car.value.y = 270;
        car.value.speed *= -0.5;
    }
    if (car.value.x < 0) {
        car.value.x = 0;
        car.value.speed = 0;
    }
    if (car.value.x > worldWidth.value - 50) {
        car.value.x = worldWidth.value - 50;
        car.value.speed = 0;
    }

    updateCamera();

    if (keys.Enter) attemptPark();

    animationFrameId = requestAnimationFrame(updatePhysics);
};

const updateCamera = () => {
    if (!viewport.value) return;
    const screenW = viewport.value.clientWidth;
    let targetCam = car.value.x - (screenW / 2);
    if (targetCam < 0) targetCam = 0;
    if (targetCam > worldWidth.value - screenW) targetCam = worldWidth.value - screenW;
    cameraX.value += (targetCam - cameraX.value) * 0.1;
};

const isCarInSpot = (spot) => {
    const cx = car.value.x + 22;
    const cy = car.value.y + 40;
    const sx = spot.rect.x + (spot.rect.w / 2);
    const sy = spot.rect.y + (spot.rect.h / 2);
    const dist = Math.sqrt((cx - sx) ** 2 + (cy - sy) ** 2);
    return dist < 40;
};

const attemptPark = () => {
    if (Math.abs(car.value.speed) > 0.5) {
        showMessage("Arrêtez-vous complètement !");
        return;
    }
    const validSpot = spots.value.find(s => isCarInSpot(s));

    if (validSpot) {
        const normalizedAngle = Math.abs(car.value.angle % 360);
        const isUp = normalizedAngle > 340 || normalizedAngle < 20;
        const isDown = normalizedAngle > 160 && normalizedAngle < 200;

        if (isUp || isDown) {
            if (validSpot.user === 'Libre') {
                showMessage("Place libre. Qui êtes-vous ?");
            } else {
                // SUCCÈS : On met à jour le v-model
                emit('update:modelValue', validSpot.user);
                stopGame();
            }
        } else {
            showMessage("Vous êtes garé de travers !");
        }
    } else {
        showMessage("Vous n'êtes pas sur une place !");
    }
};

const showMessage = (msg) => {
    message.value = msg;
    setTimeout(() => message.value = '', 2000);
};

// --- CONTROLS ---
const handleKey = (e, state) => {
    if (keys.hasOwnProperty(e.key)) {
        keys[e.key] = state;
        // Empêcher le scroll seulement si le jeu est actif
        if (gameActive.value && e.key.startsWith('Arrow')) e.preventDefault();
    }
};

const handleKeyDown = (e) => handleKey(e, true);
const handleKeyUp = (e) => handleKey(e, false);

const startGame = () => {
    initWorld();
    gameActive.value = true;
    window.addEventListener('keydown', handleKeyDown);
    window.addEventListener('keyup', handleKeyUp);
    animationFrameId = requestAnimationFrame(updatePhysics);
};

const stopGame = () => {
    gameActive.value = false;
    cancelAnimationFrame(animationFrameId);
    window.removeEventListener('keydown', handleKeyDown);
    window.removeEventListener('keyup', handleKeyUp);
};

// Nettoyage si le composant est démonté pendant le jeu
onUnmounted(() => {
    stopGame();
});

const carStyle = computed(() => ({
    transform: `translate(${car.value.x}px, ${car.value.y}px) rotate(${car.value.angle}deg)`
}));
</script>

<template>
    <div class="parking-input-wrapper">
        <div
            class="fake-input"
            :class="{ 'filled': modelValue }"
            @click="startGame"
        >
            <span v-if="modelValue">{{ modelValue }}</span>
            <span v-else class="placeholder">Cliquez pour garer votre pseudo...</span>
            <span class="icon">{{ modelValue ? '✅' : '🚗' }}</span>
        </div>

        <Teleport to="body">
            <div v-if="gameActive" class="game-modal">
                <div class="hud">
                    <div class="speed">Vitesse: {{ Math.abs(Math.round(car.speed * 10)) }} km/h</div>
                    <small>Flèches pour conduire. ESPACE pour freiner. ENTRÉE pour valider.</small>
                    <button @click="stopGame" class="quit-btn">Quitter</button>
                </div>

                <div class="game-container" ref="viewport">
                    <div class="world" :style="{ width: worldWidth + 'px', transform: `translateX(${-cameraX}px)` }">
                        <div class="road">
                            <div v-for="spot in spots" :key="spot.id"
                                 class="parking-spot"
                                 :class="['spot-top', { 'valid-zone': isCarInSpot(spot) }]"
                                 :style="{ left: spot.x + 'px' }">
                                <span>{{ spot.user }}</span>
                            </div>
                            <div class="car" :style="carStyle">
                                <div class="lights">
                                    <div class="light l"></div>
                                    <div class="light r"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <transition name="pop">
                    <div v-if="message" class="message-toast">{{ message }}</div>
                </transition>
            </div>
        </Teleport>
    </div>
</template>

<style scoped>
/* --- Styles de l'Input --- */
.fake-input {
    border: 2px solid #ddd;
    padding: 12px;
    border-radius: 6px;
    background: #fafafa;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.2s;
    font-family: monospace;
}

.fake-input:hover {
    border-color: #333;
    background: #fff;
}

.fake-input.filled {
    border-color: #2ecc71;
    background: #eafaf1;
    color: #27ae60;
    font-weight: bold;
}

.placeholder {
    color: #888;
}

/* --- Styles du Jeu --- */
.game-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.9);
    z-index: 9999;
    display: flex;
    flex-direction: column;
    font-family: sans-serif;
}

.hud {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 10px 30px;
    border-radius: 30px;
    text-align: center;
    border: 1px solid #555;
    z-index: 200;
}

.quit-btn {
    margin-top: 5px;
    background: none;
    border: 1px solid #aaa;
    color: #aaa;
    padding: 2px 8px;
    border-radius: 4px;
    cursor: pointer;
}

.game-container {
    flex: 1;
    overflow: hidden;
    position: relative;
    background: #2c3e50;
}

.world {
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: #353434;
    display: flex;
    align-items: center;
}

.road {
    height: 300px;
    background: #34495e;
    position: relative;
    border-top: 10px solid #bdc3c7;
    border-bottom: 10px solid #bdc3c7;
    box-sizing: content-box;
}

.road::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #fff 50%, transparent 50%);
    background-size: 80px 100%;
    transform: translateY(-50%);
    opacity: 0.5;
}

.parking-spot {
    position: absolute;
    width: 90px;
    height: 130px;
    border: 2px solid rgba(255, 255, 255, 0.6);
    box-sizing: border-box;
    display: flex;
    justify-content: center;
    align-items: flex-end;
    color: rgba(255, 255, 255, 0.8);
    font-weight: bold;
    font-size: 12px;
    padding-bottom: 10px;
}

.spot-top {
    top: 0;
    border-bottom: none;
}

.spot-top span {
    margin-bottom: 80px;
}

.valid-zone {
    background: rgba(46, 204, 113, 0.2);
    border-color: #2ecc71;
}

.car {
    width: 44px;
    height: 80px;
    background: #e74c3c;
    border-radius: 6px;
    position: absolute;
    top: 0;
    left: 0;
    transform-origin: center center;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    z-index: 10;
}

.car::after {
    content: '';
    position: absolute;
    top: 15px;
    left: 4px;
    right: 4px;
    bottom: 10px;
    background: #c0392b;
    border-radius: 4px;
}

.car::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 6px;
    right: 6px;
    height: 15px;
    background: #333;
    border-radius: 2px;
    z-index: 1;
}

.lights {
    position: absolute;
    top: 0;
    width: 100%;
    height: 10px;
}

.light {
    width: 8px;
    height: 12px;
    background: #f1c40f;
    border-radius: 4px;
    position: absolute;
    top: -2px;
    box-shadow: 0 0 10px #f1c40f;
}

.light.l {
    left: 4px;
}

.light.r {
    right: 4px;
}

.message-toast {
    position: absolute;
    bottom: 100px;
    left: 50%;
    transform: translateX(-50%);
    background: #e74c3c;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
}

.pop-enter-active, .pop-leave-active {
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.pop-enter-from, .pop-leave-to {
    transform: translateX(-50%) scale(0.5);
    opacity: 0;
}
</style>