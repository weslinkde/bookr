#Bookr
###About Bookr
Bookr gives users a possibility to manage their life's and/or their team's assets.

###Documentation

<ul>
    <li>
        See <a href="#">PROJECT DEMO</a> for demo project
    </li>
    <li>
        See [DOCUMENTATION](#documentation) for project documentation
    </li>
    <li>
        See [INSTALL](#installation-guide) for installation instructions
    </li>
    <li>
        See <a href="https://github.com/weslinkde/bookr/commits/develop">CHANGES</a> for version history
    </li>
    <li>
        See <a href="https://github.com/weslinkde/bookr/blob/master/LICENSE">LICENCE</a> for licencing terms
    </li>
</ul>

###Installation guide

Clone the Github repository: <br>
```git clone https://github.com/weslinkde/bookr.git```

Switch to the repo folder <br>
```cd dev/bookr```

Install all the dependencies using composer <br>
```composer install```

Generate a new application key <br>
```php artisan key:generate```

Run the database migrations <b>(Set the database connection in .env before migrating)</b> <br>
```php artisan migrate --seed```

Start the local development server <br>
```php artisan serve```

You can now access the server at ```http://localhost:8000```

###Screenshots

<img src="" rel="Bookr screenshot 1">

<img src="" rel="Bookr screenshot 2">

<img src="" rel="Bookr screenshot 3">
