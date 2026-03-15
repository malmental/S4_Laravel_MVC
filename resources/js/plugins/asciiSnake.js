/**
 * Plugin: asciiSnake
 * Descripción: Componente Alpine para el mini-juego Snake en formato ASCII.
 * 
 * Uso en HTML:
 *   <body x-data="asciiSnake" @keydown.window="handleKey($event)">
 *     <button @click="openGame()">Jugar Snake</button>
 *   </body>
 * 
 * Características:
 *   - Tablero de 32x32 celdas
 *   - Controles: Flechas del teclado o WASD
 *   - Renderizado en texto ASCII
 *   - Puntuación, pausa y game over
 * 
 * Símbolos del juego:
 *   · = Celda vacía
 *   * = Comida
 *   @ = Cabeza de la serpiente
 *   o = Cuerpo de la serpiente
 */

export default () => ({
    // ============================================
    // CONFIGURACIÓN
    // ============================================
    
    /** Tamaño del tablero (32x32) */
    size: 32,
    
    /** Velocidad del juego en milisegundos entre ticks */
    tickMs: 120,

    // ============================================
    // ESTADO DE LA INTERFAZ (UI)
    // ============================================
    
    /** Indica si el modal del juego está abierto */
    gameOpen: false,
    
    /** Indica si el juego está en ejecución */
    running: false,
    
    /** Indica si el juego está en pausa */
    paused: false,
    
    /** Indica si el juego ha terminado (game over) */
    gameOver: false,
    
    /** Puntuación actual del jugador */
    score: 0,

    // ============================================
    // ESTADO DEL JUEGO
    // ============================================
    
    /** Dirección actual de movimiento (up, down, left, right) */
    direction: 'right',
    
    /** Próxima dirección (para evitar giros de 180°) */
    nextDirection: 'right',
    
    /** Array de posiciones de la serpiente [{x, y}, ...] */
    snake: [],
    
    /** Posición de la comida {x, y} */
    food: { x: 0, y: 0 },
    
    /** Texto ASCII del tablero para renderizar en <pre> */
    boardText: '',
    
    /** ID del interval para el loop del juego */
    timerId: null,

    // ============================================
    // MÉTODOS DE CONTROL DEL MODAL
    // ============================================
    
    /**
     * Abre el modal del juego.
     * Si no hay partida activa, dibuja el tablero vacío.
     */
    openGame() {
        this.gameOpen = true;
        if (!this.running && !this.gameOver) {
            this.drawEmptyBoard();
        }
    },

    /**
     * Cierra el modal y detiene el loop del juego.
     * Evita timers colgados.
     */
    closeGame() {
        this.gameOpen = false;
        this.stopLoop();
        this.running = false;
        this.paused = false;
    },

    // ============================================
    // MÉTODOS DEL JUEGO
    // ============================================
    
    /**
     * Inicializa y comienza una partida nueva.
     * Resetea puntuación, dirección y posiciona la serpiente en el centro.
     */
    startGame() {
        this.stopLoop();
        this.running = true;
        this.paused = false;
        this.gameOver = false;
        this.score = 0;
        this.direction = 'right';
        this.nextDirection = 'right';

        // Crear serpiente inicial de 3 segmentos en el centro
        const center = Math.floor(this.size / 2);
        this.snake = [
            { x: center, y: center },      // Cabeza
            { x: center - 1, y: center },  // Cuerpo 1
            { x: center - 2, y: center },  // Cuerpo 2
        ];

        this.spawnFood();
        this.renderBoard();
        this.startLoop();
    },

    /**
     * Alterna entre pausa y reanudación del juego.
     * No hace nada si el juego no está corriendo o ya terminó.
     */
    togglePause() {
        if (!this.running || this.gameOver) {
            return;
        }

        this.paused = !this.paused;
    },

    // ============================================
    // CONTROL DE INPUT (TECLADO)
    // ============================================
    
    /**
     * Maneja las teclas presionadas para mover la serpiente.
     * Mapea flechas y WASD a direcciones.
     * Evita giros de 180° (no se puede ir directamente de left a right).
     * 
     * @param {KeyboardEvent} event - Evento del teclado
     */
    handleKey(event) {
        // Ignorar teclas si el juego no está abierto
        if (!this.gameOpen) {
            return;
        }

        const key = event.key.toLowerCase();
        
        // Mapa de teclas a direcciones
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

        // Direcciones opuestas (no permitidas como cambio inmediato)
        const opposite = {
            up: 'down',
            down: 'up',
            left: 'right',
            right: 'left',
        };

        // Solo cambiar dirección si no es opuesta a la actual
        if (requested !== opposite[this.direction]) {
            this.nextDirection = requested;
        }
    },

    // ============================================
    // LOOP DEL JUEGO
    // ============================================
    
    /**
     * Inicia el loop del juego con setInterval.
     * Ejecuta un tick() cada tickMs milisegundos.
     */
    startLoop() {
        this.stopLoop();
        this.timerId = setInterval(() => {
            // No ejecutar tick si el juego no está activo
            if (!this.running || this.paused || this.gameOver || !this.gameOpen) {
                return;
            }
            this.tick();
        }, this.tickMs);
    },

    /**
     * Detiene el loop del juego limpiando el interval.
     */
    stopLoop() {
        if (this.timerId) {
            clearInterval(this.timerId);
            this.timerId = null;
        }
    },

    /**
     * Ejecuta un paso del juego:
     * 1. Mueve la serpiente en la dirección actual
     * 2. Detecta colisiones con paredes y cuerpo
     * 3. Detecta comida (crece la serpiente)
     * 4. Renderiza el tablero
     */
    tick() {
        // Actualizar dirección
        this.direction = this.nextDirection;
        const head = this.snake[0];
        const nextHead = { x: head.x, y: head.y };

        // Calcular nueva posición según dirección
        if (this.direction === 'up') nextHead.y -= 1;
        if (this.direction === 'down') nextHead.y += 1;
        if (this.direction === 'left') nextHead.x -= 1;
        if (this.direction === 'right') nextHead.x += 1;

        // Collision con paredes - fin del juego
        if (
            nextHead.x < 0 ||
            nextHead.x >= this.size ||
            nextHead.y < 0 ||
            nextHead.y >= this.size
        ) {
            this.endGame();
            return;
        }

        // Detectar si come comida
        const willGrow = nextHead.x === this.food.x && nextHead.y === this.food.y;
        
        // Detectar colisión con el cuerpo
        // Si va a crecer, no comprobar el último segmento (se mueve)
        const bodyToCheck = willGrow ? this.snake : this.snake.slice(0, -1);
        const hitBody = bodyToCheck.some((segment) => segment.x === nextHead.x && segment.y === nextHead.y);

        // Colisión con cuerpo - fin del juego
        if (hitBody) {
            this.endGame();
            return;
        }

        // Mover serpiente: agregar nueva cabeza
        this.snake.unshift(nextHead);

        // Si comió: incrementar puntuación y generar nueva comida
        // Si no: quitar la cola (movimiento normal)
        if (willGrow) {
            this.score += 1;
            this.spawnFood();
        } else {
            this.snake.pop();
        }

        // Renderizar tablero
        this.renderBoard();
    },

    /**
     * Finaliza el juego (game over).
     * Detiene el loop y renderiza el estado final.
     */
    endGame() {
        this.gameOver = true;
        this.running = false;
        this.paused = false;
        this.stopLoop();
        this.renderBoard();
    },

    /**
     * Genera comida en una posición aleatoria del tablero.
     * Asegura que no aparezca sobre la serpiente.
     */
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

    // ============================================
    // RENDERIZADO ASCII
    // ============================================
    
    /**
     * Dibuja el tablero vacío (antes de iniciar el juego).
     * Usa '·' para celdas vacías.
     */
    drawEmptyBoard() {
        const emptyLine = '·'.repeat(this.size);
        this.boardText = Array(this.size).fill(emptyLine).join('\n');
    },

    /**
     * Convierte el estado actual del juego en texto ASCII.
     * Representa:
     *   - '·' = celda vacía
     *   - '*' = comida
     *   - '@' = cabeza de la serpiente
     *   - 'o' = cuerpo de la serpiente
     */
    renderBoard() {
        // Crear grid vacío
        const grid = Array.from({ length: this.size }, () => Array(this.size).fill('·'));
        
        // Colocar comida
        grid[this.food.y][this.food.x] = '*';

        // Colocar serpiente
        this.snake.forEach((segment, index) => {
            grid[segment.y][segment.x] = index === 0 ? '@' : 'o';
        });

        // Convertir grid a string ASCII
        this.boardText = grid.map((row) => row.join('')).join('\n');
    },
});
