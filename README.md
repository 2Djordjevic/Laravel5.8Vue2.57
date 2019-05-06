# laraVue
It's a Admin Panel Stater For Laravel and Vue.js. <br>

<b> This repo is based on practical web application development course on youtube. </b><br> 
https://www.youtube.com/playlist?list=PLB4AdipoHpxaHDLIaMdtro1eXnQtl_UvE<br>

And I added something a bit change.

Becase It has some issues I hope you will update this source by branch.
I'm writing issues that it contain yet.

<b> Here are the things you will learn in this series and what the repo include out of the box: </b>

* How use Vue Router with Laravel
* How to Install AdminLTE 3
* How to Use Font Awesome 5 on Laravel
* How to Use Bootstrap 4 on Laravel
* How to Use API in Laravel
* How to Use Vue Components
* Database Migration on Laravel
* Database Seeding on Laravel
* Api Auth with Laravel Passport
* JWT with Laravel Passport and JavaScript Request
* Vue Custom Events
* Vue form with Laravel
* Relational Database with Laravel
* Axios and Ajax Request
* ACL in Laravel
* Online Users list
* And much more...

## Installation

It's just like any other Laravel project. Basically here is how you use it for yourself. (It's not completed yet and you have to add more functions.) 

* Clone the repo ` git clone https://github.com/daranyK/laravelVue.git `
* `cd ` to project folder. 
* Run ` composer install `
* Save as the `.env.example` to `.env` and set your database information 
* Run ` php artisan key:generate` to generate the app key
* Run ` npm install ` 
* Run ` php artisan migrate ` 
* Run ` composer dump-autoload ` 
* Run ` php artisan db:seed `
* Run ` php artisan passport:keys `

## Run Service

* Run ` npm run watch `
* Run ` php artisan serve `

## Login
* Login ID: ` admin@me.com `
* Password: ` admin `

## Issues

* Profile photo
1. After update your profile photo don't change avatar on Sidebar menu.
2. When open profile at first don't show default profime image on Profile page

* Select Empty User Role <br>
When you update with Empty User Role ("Select User Role") on Update User Dialog, you can show "Update Failed!" alert.But can't see error message beside of "Type" select. For Example "The Type field is required."

* Change Invoice Menu Icon


## Tutorial Description 

Thanks to Hujjat Nazari.
I like his course on Youtube.

https://github.com/Hujjat/laravStart.git <br>
https://www.youtube.com/playlist?list=PLB4AdipoHpxaHDLIaMdtro1eXnQtl_UvE
