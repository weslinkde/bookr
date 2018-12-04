<div align="center" style="border-bottom: 1px solid black;">
    <h1 style="border: none;">Bookr</h1>
    <p>An easy to use Booking System</p>
</div>
<br>

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

You can now access the server at <br>
 ```http://localhost:8000```

### Screenshots
Main Menu <br>
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Main-Menu" rel="Bookr Main Menu">

Team Panel <br>
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Team-Panel" rel="Bookr Team Panel">

Assets <br>
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Calendar-Example" rel="Bookr Calendar Example">

Booking Modal <br>
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Calendar-Modal" rel="Bookr Calendar Modal">

### Tutorial
When you first log in you will be redirected to the <a href="#screenshots">Main Menu</a>, here you can create a personal calendar or create a team.

You can use team's to create Shared <a href="#screenshots">Assets</a> like Company Beamer's.

When you have created a calendar you will be able to add Assets and personal calendars. When you have created an asset, it will be displayed at the <a href="#screenshots">Main Menu</a>.

When you click on the asset you have created, you will be redirected to the reservation page of the <a href="#screenshots">asset</a>.

Here you are able to create reservations for that asset, by dragging from and to the desired times.

An modalbox will popup and you will be able to give more information about the reservation, specify the given time and make the reservation recurring.

You are also able to edit the date and time of the reservation by resizing it and/or dragging it to a different time / day. And you will be able to click on the reservation to edit / view the given information.

Only the creator and the team admin will be able to edit and delete the reservation, other team members will not be able to edit the reservation.