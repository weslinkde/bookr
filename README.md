<div align="center">
    <h1>Bookr</h1>
    <p>An easy to use Reservation System</p>
</div>
<br>

### About Bookr
Bookr is an easy to use Reservation / Booking System, that allows users to create calendars and create team's for their company's.

### Documentation

<h4>Table of content</h4>
<ul>
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
        See <a href="#tutorial">TUTORIAL</a> for a tutorial
    </li>
    <li>
        See <a href="https://github.com/weslinkde/bookr/commits/develop">CHANGES</a> for the changelog
    </li>
    <li>
        See <a href="https://github.com/weslinkde/bookr/blob/develop/LICENSE">LICENCE</a> for licencing terms
    </li>
</ul>

<h4>Functions</h4>
<ul>
    <li>
        <b>Booking Functions</b>
        <ul>
            <li>Creating reservations</li>
            <li>Editing reservations</li>
            <li>Viewing reservations</li>
            <li>Recurring reservations</li>
        </ul>
    </li>
    <li>
        <b>Personal Calendars</b>
        <ul>
            <li>CRUD Calendars</li>
            <li>CRUD Assets / Items</li>
            <li><b>Booking Functions</b></li>
        </ul>
    </li>
    <li>
        <b>Team Calendars</b>
        <ul>
            <li>CRUD Teams</li>
            <li>Viewing team information</li>
            <li>Inviting members</li>
            <li>Managing members</li>
            <li>CRUD Calendars</li>
            <li>CRUD Assets / Items</li>
            <li><b>Booking Functions</b></li>
        </ul>
    </li>
</ul>

### Installation guide
<a href="#documentation">Back to documentation</a><br>
Clone the Github repository: <br>
```git clone https://github.com/weslinkde/bookr.git```

Switch to the repo folder <br>
```cd bookr```

Install all the dependencies using composer <br>
```composer install```

Run the database migrations <b>(Set the database connection in .env before migrating)</b> <br>
```php artisan migrate --seed```

Start the local development server <br>
```php artisan serve```

You can now access the server at <br>
 ```http://localhost:8000```

### Screenshots
<a href="#documentation">Back to documentation</a><br><div align="center">

##### Main Menu
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Main-Menu" rel="Bookr Main Menu"> <br>

##### Team Panel
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Team-Panel" rel="Bookr Team Panel"> <br>

##### Booking Calendar
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Calendar-Example" rel="Bookr Calendar Example"> <br>

##### Booking Modal
<img src="https://github.com/weslinkde/bookr/blob/develop/screenshots/Bookr-Calendar-Modal" rel="Bookr Calendar Modal"> <br>
</div>

### Tutorial
<a href="#documentation">Back to documentation</a><br><br>
When you first log in you will be redirected to the <a href="#main-menu">Main Menu</a>, here you can create a personal calendar or create a team.

You can use teams to create Shared <a href="#team-panel">Assets</a> like a Company's Beamers.

When you have created a calendar you will be able to add Assets / Agenda's. When you have created an asset, it will be displayed at the <a href="#main-menu">Main Menu</a>.

When you click on the asset you have created, you will be redirected to the reservation page of the <a href="#booking-calendar">Asset</a>.

Here you are able to create reservations for that asset, by dragging from and to the desired times.

An <a href="#booking-modal">modalbox</a> will popup and you will be able to give more information about the reservation, specify the given time and make the reservation recurring.

You are also able to edit the date and time of the reservation by resizing it and/or dragging it to a different time / day.

Only the creator and the team admin will be able to edit and delete the reservation, other team members will not be able to edit the reservation.