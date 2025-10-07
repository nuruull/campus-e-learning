/*
This file will be used by jetstream to add alpine.js. This file must exist to install jetstream successfully.
You can remove it if you don't want to use jetstream.
*/

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'reverb', // Atau 'pusher' jika Anda menggunakan Pusher
  key: process.env.MIX_REVERB_APP_KEY,
  wsHost: process.env.MIX_REVERB_HOST,
  wsPort: process.env.MIX_REVERB_PORT,
  wssPort: process.env.MIX_REVERB_PORT,
  forceTLS: (process.env.MIX_REVERB_SCHEME || 'http') === 'https',
  enabledTransports: ['ws', 'wss'],
});

console.log('Laravel Echo configured and running!');
