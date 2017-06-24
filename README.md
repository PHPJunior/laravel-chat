# Laravel Chat [ WIP ]
Simple Laravel Group Chat Module

[![Latest Stable Version](https://poser.pugx.org/php-junior/laravel-chat/v/stable)](https://packagist.org/packages/php-junior/laravel-chat)
[![Total Downloads](https://poser.pugx.org/php-junior/laravel-chat/downloads)](https://packagist.org/packages/php-junior/laravel-chat)


## Installation

Install using composer:
```json
 composer require php-junior/laravel-chat
```

Once installed, in your project's `config/app.php` file replace the following entry from the providers array:

```php
 PhpJunior\LaravelChat\LaravelChatServiceProvider::class,
```
And 
```php 
 php artisan vendor:publish --provider="PhpJunior\LaravelChat\LaravelChatServiceProvider"
 php artisan queue:table
 php artisan queue:failed-table
 php artisan migrate
```

Uncomment `App\Providers\BroadcastServiceProvider` in the providers array of your `config/app.php` configuration file

## Configuration

```text
 BROADCAST_DRIVER=pusher
 PUSHER_APP_ID=your-pusher-app-id
 PUSHER_APP_KEY=your-pusher-app-key
 PUSHER_APP_SECRET=your-pusher-app-secret
 PUSHER_APP_CLUSTER=your-pusher-app-cluster
```

Add the `PhpJunior\LaravelChat\Models\UserGroup` trait to your `User` model

Install the JavaScript dependencies:
```javascript
 npm install
 npm install --save laravel-echo pusher-js vue-timeago
```

At the bottom of `resources/assets/js/bootstrap.js` file:
```javascript
 import Echo from "laravel-echo"
 window.Pusher = require('pusher-js');
 
 window.Echo = new Echo({
     broadcaster: 'pusher',
     key: 'your-pusher-app-key',
     cluster: 'your-pusher-app-cluster',
     encrypted: true
 });
```

In `resources/assets/js/app.js` file:
```vuejs
 import VueTimeago from 'vue-timeago';
 window.Bus = new Vue();
 
 Vue.component('groups', require('./components/laravel-chat/Groups.vue'));
 Vue.component('create-group', require('./components/laravel-chat/CreateGroup.vue'));
 Vue.component('group-chat', require('./components/laravel-chat/GroupChat.vue'));
 
 Vue.use(VueTimeago, {
     name: 'timeago', // component name, `timeago` by default
     locale: 'en-US',
     locales: {
         // you will need json-loader in webpack 1
         'en-US': require('vue-timeago/locales/en-US.json')
     }
 })
```

Run `npm run dev` to recompile your assets.

## Usage

```php
 $groups = auth()->user()->groups;
 $users = User::where('id', '<>', auth()->user()->id)->get();
 $user = auth()->user();
 return view('home', [ 'groups' => $groups , 'users' => $users , 'user' => $user ]); 
```

In your templates

```blade
 <create-group :initial-users="{{ $users }}" :current-user="{{ $user }}"></create-group>
 <groups :initial-groups="{{ $groups }}" :user="{{ $user }}"></groups>
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Do not forget to run the queue listener to broadcast the events
