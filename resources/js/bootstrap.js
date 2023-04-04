window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */


import Echo from 'laravel-echo'
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});


// import Echo from 'laravel-echo';
//
// window.Echo = Echo;
// export default Echo;
//
// window.Pusher = require('pusher-js');
//
//
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//
// });

// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
//
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
// let token = $('meta[name="csrf-token"]').attr('content')
// // console.log(token)
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '1c99a34adcc4a4c2dc98',
//     cluster: 'eu',
//     encrypted: true,
//     auth: {
//         headers: {
//             Authorization: 'Bearer ' + token
//         },
//     },
// });


// let token = $('meta[name="csrf-token"]').attr('content')
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true,
//     authEndpoint: '/broadcasting/auth',
//     auth: {
//         headers: {
//             Authorization: 'Bearer ' + token
//         }
//     }
// });



// window.Echo.private('private-chatify')
//     .listen('.ChatifyNewMessage', (e) => {
//         console.log(e);
//         console.log('111111111111111111111');
//     });
// window.Echo.private('channelName')
//     .listen('EventName', (e) => {
//         console.log(e);
//         console.log('222222222222222222222222');
//     });



