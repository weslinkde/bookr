# Bookr
### About Bookr
Bookr gives users a possibility to manage their life's and/or their team's assets.

### Documentation

<ul>
    <li>
        See <a href="#">PROJECT DEMO</a> for demo project
    </li>
    <li>
        See <a href="#documentation">DOCUMENTATION</a> for project documentation
    </li>
    <li>
        See <a href="#installation-guide">INSTALL</a> for installation instructions
    </li>
    <li>
        See <a href="#screenshots">SCREENSHOTS</a> for screenshots
    </li>
    <li>
        See <a href="https://github.com/weslinkde/bookr/commits/develop">CHANGES</a> for version history
    </li>
    <li>
        See <a href="https://github.com/weslinkde/bookr/blob/develop/LICENSE">LICENCE</a> for licencing terms
    </li>
</ul>

### Installation guide

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

### Screenshots

<img src="https://github.com/weslinkde/bookr/blob/develop/bookr/screenshots/bookr-main-menu" rel="Bookr Main Menu">

<img src="https://github.com/weslinkde/bookr/blob/develop/bookr/screenshots/bookr-team-panel" rel="Bookr Team Panel">

<img src="https://github.com/weslinkde/bookr/blob/develop/bookr/screenshots/bookr-calendar-example" rel="Bookr Calendar Example">

### Tutorial

When you first log in you will be redirected to the main menu (See screenshot #1), here you can create a personal calendar or create a team. <br> You can use team's to create shared assets like Company Beamer's (See screenshot #2). <br> When you have created a calendar you will be able to add Assets and personal calendars. When you have created an asset, it will be displayed at the main menu (See screentshot #1). <br> When you click on the asset you have created, you will be redirected to the reservation page of the asset (See screenshot #3). <br> Here you are able to create reservations for that asset, by dragging from and to the desired times. <br> An modalbox will popup and you will be able to give more information about the reservation, specify the given time and make the reservation recurring.
