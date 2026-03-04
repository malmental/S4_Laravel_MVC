import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ASCII Snake: estado, reglas y render del mini-juego en el modal global.
Alpine.data('asciiSnake', () => ({
    // Configuracion base del tablero y velocidad.
    size: 32,
    tickMs: 120,
    // Estado de UI del modal y del juego.
    gameOpen: false,
    running: false,
    paused: false,
    gameOver: false,
    score: 0,
    // Estado interno de movimiento.
    direction: 'right',
    nextDirection: 'right',
    snake: [],
    food: { x: 0, y: 0 },
    // Salida de texto ASCII que se pinta en <pre>.
    boardText: '',
    timerId: null,

    // Abre el modal y prepara tablero vacio si aun no hay partida.
    openGame() {
        this.gameOpen = true;
        if (!this.running && !this.gameOver) {
            this.drawEmptyBoard();
        }
    },

    // Cierra modal y detiene el loop para evitar timers colgados.
    closeGame() {
        this.gameOpen = false;
        this.stopLoop();
        this.running = false;
        this.paused = false;
    },

    // Inicializa una partida nueva.
    startGame() {
        this.stopLoop();
        this.running = true;
        this.paused = false;
        this.gameOver = false;
        this.score = 0;
        this.direction = 'right';
        this.nextDirection = 'right';

        const center = Math.floor(this.size / 2);
        this.snake = [
            { x: center, y: center },
            { x: center - 1, y: center },
            { x: center - 2, y: center },
        ];

        this.spawnFood();
        this.renderBoard();
        this.startLoop();
    },

    // Pausa/reanuda la partida activa.
    togglePause() {
        if (!this.running || this.gameOver) {
            return;
        }

        this.paused = !this.paused;
    },

    // Mapea flechas/WASD y bloquea giros de 180 grados.
    handleKey(event) {
        if (!this.gameOpen) {
            return;
        }

        const key = event.key.toLowerCase();
        const map = {
            arrowup: 'up',
            w: 'up',
            arrowdown: 'down',
            s: 'down',
            arrowleft: 'left',
            a: 'left',
            arrowright: 'right',
            d: 'right',
        };

        const requested = map[key];
        if (!requested) {
            return;
        }

        event.preventDefault();

        const opposite = {
            up: 'down',
            down: 'up',
            left: 'right',
            right: 'left',
        };

        if (requested !== opposite[this.direction]) {
            this.nextDirection = requested;
        }
    },

    // Controla el loop de juego por ticks.
    startLoop() {
        this.stopLoop();
        this.timerId = setInterval(() => {
            if (!this.running || this.paused || this.gameOver || !this.gameOpen) {
                return;
            }
            this.tick();
        }, this.tickMs);
    },

    // Detiene el loop activo.
    stopLoop() {
        if (this.timerId) {
            clearInterval(this.timerId);
            this.timerId = null;
        }
    },

    // Ejecuta un paso del juego: mover, colisiones, comida y render.
    tick() {
        this.direction = this.nextDirection;
        const head = this.snake[0];
        const nextHead = { x: head.x, y: head.y };

        if (this.direction === 'up') nextHead.y -= 1;
        if (this.direction === 'down') nextHead.y += 1;
        if (this.direction === 'left') nextHead.x -= 1;
        if (this.direction === 'right') nextHead.x += 1;

        if (
            nextHead.x < 0 ||
            nextHead.x >= this.size ||
            nextHead.y < 0 ||
            nextHead.y >= this.size
        ) {
            this.endGame();
            return;
        }

        const willGrow = nextHead.x === this.food.x && nextHead.y === this.food.y;
        const bodyToCheck = willGrow ? this.snake : this.snake.slice(0, -1);
        const hitBody = bodyToCheck.some((segment) => segment.x === nextHead.x && segment.y === nextHead.y);

        if (hitBody) {
            this.endGame();
            return;
        }

        this.snake.unshift(nextHead);

        if (willGrow) {
            this.score += 1;
            this.spawnFood();
        } else {
            this.snake.pop();
        }

        this.renderBoard();
    },

    // Marca fin de partida y congela estado.
    endGame() {
        this.gameOver = true;
        this.running = false;
        this.paused = false;
        this.stopLoop();
        this.renderBoard();
    },

    // Coloca comida en una celda libre.
    spawnFood() {
        let attempts = 0;
        const maxAttempts = this.size * this.size;

        do {
            this.food = {
                x: Math.floor(Math.random() * this.size),
                y: Math.floor(Math.random() * this.size),
            };
            attempts += 1;
        } while (
            attempts < maxAttempts &&
            this.snake.some((segment) => segment.x === this.food.x && segment.y === this.food.y)
        );
    },

    // Render inicial en reposo.
    drawEmptyBoard() {
        const emptyLine = '·'.repeat(this.size);
        this.boardText = Array(this.size).fill(emptyLine).join('\n');
    },

    // Convierte el estado actual del juego en texto ASCII.
    renderBoard() {
        const grid = Array.from({ length: this.size }, () => Array(this.size).fill('·'));
        grid[this.food.y][this.food.x] = '*';

        this.snake.forEach((segment, index) => {
            grid[segment.y][segment.x] = index === 0 ? '@' : 'o';
        });

        this.boardText = grid.map((row) => row.join('')).join('\n');
    },
}));

Alpine.start();
