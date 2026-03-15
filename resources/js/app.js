import './bootstrap';

import Alpine from 'alpinejs';
import asciiSnake from './plugins/asciiSnake';

window.Alpine = Alpine;

Alpine.data('asciiSnake', asciiSnake);

Alpine.start();
