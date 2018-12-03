# Bookr
#### About Bookr
Bookr gives users a possibility to manage their life's and/or their team's assets.
<ul>
    <li>
        <a href="#">Project demo</a>
    </li>
    <li>
        <a href="#">Documentation</a>
    </li>
    <li>
        <a href="#">Changelog</a>
    </li>
    <li>
        <a href="#">License</a>
    </li>
</ul>

#### Installation guide

Clone the Github repository: <br>
```git clone https://github.com/weslinkde/bookr.git```

Switch to the repo folder <br>
```cd dev/bookr```

Install all the dependencies using composer <br>
```composer install```

Generate a new application key <br>
```php artisan key:generate```

Run the database migrations (Set the database connection in .env before migrating) <br>
```php artisan migrate --seed```

Start the local development server <br>
```php artisan serve```

You can now access the server at http://localhost:8000