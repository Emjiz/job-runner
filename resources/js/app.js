import './bootstrap';

// Import Livewire
import { Livewire } from 'livewire';

// Check if Livewire is loaded
if (window.Livewire) {
    console.log('Livewire is initialized.');
}

// Initialize Livewire if necessary (optional, Livewire should auto-init)
Livewire.start();