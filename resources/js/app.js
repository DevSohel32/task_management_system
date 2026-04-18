import './bootstrap';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
window.Chart = Chart;
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
